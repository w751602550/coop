<?php


namespace app\home\controller;


use app\home\model\Invoice;
use think\Exception;
use think\facade\Request;
use app\home\model\MemberGoods;
use app\home\model\Order as orderModel;

class Order extends Base
{
    protected $geterror;

    public function index()
    {
        $condition = [];
        $model = new orderModel();
        $search_status = 0;
        if ($this->post) {
            $post = postData('search');
            $search_status = $post['status'];
            $post['status'] && $condition[] = ['status', '=', $post['status']];
            $post['start_time'] && $condition[] = ['create_time', '>', strtotime($post['start_time'])];
            $post['end_time'] && $condition[] = ['create_time', '<', strtotime($post['end_time'])];
            $post['order_sn'] && $condition[] = ['order_sn', '=', trim($post['order_sn'])];
            $this->assign('search', $post);
        }
        $status = $model->data;
        $list = $model->getPage($condition);
        return $this->fetch('index', compact('list', 'status', 'search_status'));
    }

    public function showMessage()
    {
       if($this->post){
           $post=input('post.');
        $content=json_encode($post).PHP_EOL;
        $log_dir=WEB_PATH.'logs'.DS.'payment'.DS.date('Ymd',time()).'.txt';
        file_put_contents($log_dir,$post,FILE_APPEND);
       }
    }

    public function confirm($order_id)
    {
        token();
        $order = orderModel::detail($order_id);
        if ($this->ajax) {
            if (!$order || $order['status']['value'] != 10)
                return ajaxError('订单状态有误');
            $post = postData('order');
            if ($post['payment_type'] == 'online') {
                $post['status'] = 15;
            } else {
                $post['confirm_time'] = time();
                $post['status'] = 20;
            }
            $post['payment_sn'] = $order->payNo();
            if ($order->edit($post, $order_id)){
                if($post['payment_type'] == 'online')
                    return ajaxSuccess('确认成功', url('order/pay', ['order_id' => $order_id]));
                return ajaxSuccess('确认成功', url('order/index', ['order_id' => $order_id]));
            }
            return ajaxError('确认失败');
        }
        if (!$order || $order['status']['value'] != 10)
                $this->error('订单状态有误');

        return $this->fetch('confirm', compact('order'));
    }

    public function combine($type = '')
    {
        if ($this->post) {
            $post = postData('order');
            if (!$post)
                return;
            $error = [];
            $total = 0;
            $order_sn = [];
            $payment_sn = [];
            $orderArr = implode(',', $post);
            $condition[] = ['order_id', 'in', $orderArr];
            $orderList = (new orderModel)->getAll($condition);
            foreach ($orderList as $key => &$val) {
                if ($val['status']['value'] != 15 || $val['payment_type'] != 'online') {
                    $error[] = [
                        'order_sn' => $val['order_sn'],
                        'error' => '订单状态有误',
                    ];
                } else {
                    $val['pay_price'] = $val['pay_price'] ?: $val['total_price'];
                    $price = $val['pay_price'] ?: $val['total_price'];
                    $total += $price;
                    $order_sn[] = $val['order_sn'];
                    $payment_sn[] = $val['order_id'] . '-' . $val['payment_sn'];
                }
            }
            if ($error) {
                return $this->fetch('combine', compact('error'));
            }
            if ($type == 'pay') {
                $pay['order_sn'] = $order_sn[0];
                $pay['payment_sn'] = encrypt(implode('|', $order_sn));
                $pay['total_price'] = $total;
                return $this->payUnion($pay);
            }
            $invoice = (new Invoice)->getAll();
            return $this->fetch('combine', compact('orderList', 'total', 'invoice'));
        }
    }

    public function pay($order_id)
    {
        $model = new orderModel();
        $order = $model->get($order_id);
        if ($this->post) {
            if (!$order || $order['status']['value'] != 15)
                return ajaxError('订单状态有误');
            return $this->payUnion($order);
        }
        if (!$order || $order['status']['value'] != 15) {
            $this->error('订单状态有误');
        }
        return $this->fetch('pay', compact('order'));
    }

    private function payUnion($order)
    {
        $data = [];
        $data['MerId'] = '541171910140001';
        $data['MerOrderNo'] = $order['order_sn'];
        $data['OrderAmt'] = $order['total_price'] * 100;
        $data['TranDate'] = date('Ymd', time());
        $data['TranTime'] = date('his', time());
        $data['BusiType'] = '0001';
        $data['Version'] = '20140728';
        $data['MerPageUrl'] = rtrim(base_url(), '/') . url('order/showMessage');
        $data['MerBgUrl'] = rtrim(base_url(), '/') . url('order/showMessage');
        //  $data['trans_P1'] = $payment_sn['pay_sn'];
        $data['MerResv'] = $order['payment_sn'];
        $data['AcqCode'] = '000000000000014';
        echo (new payment\unionpay\Unionpay())->bulidSign($data);
        exit();
    }

    public function import($error = '')
    {
        return $this->fetch('import', compact('error'));
    }

    public function importFile()
    {
        $error = [];
        if ($this->post) {
            if (!$data = $this->getExcel()) {
                $error = $this->geterror;
            } else {
                $error = $this->geterror;
                if (!$error) {
                    $orderModel = new orderModel();
                    if ($orderModel->buildOrder($data)) {
                        return redirect('order/index');
                    }
                }
            }
        }
        return $this->import($error);
    }

    public function showError($error)
    {
        return $this->fetch('import', compact('error'));
    }

    public function getExcel()
    {
        if (!$file = Request::file('iFile')) {
            $this->geterror = '文件不存在';
            return false;
        }
        $uploadPath = WEB_PATH . 'upload' . DS . 'file';
        $info = $file->validate(['size' => 10 * 1024 * 1024, 'ext' => 'xls,xlsx'])->move($uploadPath);
        if (!$info) {
            $this->geterror = '文件过大或格式不正确，上传失败';
            return false;
        }
        $ext = strtolower($info->getExtension());
        $filePath = $uploadPath . DS . $info->getSaveName();
        try{
            if ($ext == 'xlsx') {
                $reader = \PHPExcel_IOFactory::createReader('Excel2007');
            } else {
                $reader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            $excel = $reader->load($filePath, $encode = 'utf-8');
        }catch (\Exception $e){
            $this->geterror='文件格式不正确，请重新转成Excel格式后上传';
            return false;
        }
        $sheet = $excel->getSheet(0)->toArray();
        if (count($sheet) < 2) {
            $this->geterror = '文件中没有数据';
            return false;
        }
        unset($sheet[0]);
        $data = [];
        $error = [];
        foreach ($sheet as $key => $val) {
            if(!$val[1])
                break;
            $member_goods = $this->checkGoodsPrice($val[8]);
            $line = ++$key;
            if (!$member_goods) {
                $error[] = "第" . $line . "行的商品($val[9])不存在或非合约商品";
                continue;
            }
            if ($member_goods['price'] != $val[12]) {
                $error[] = "第" . $line . "行的商品($val[9])价格与合约商品价格不一致";
                continue;
            }
            if (round($val[10]) < 1) {
                $error[] = "第" . $line . "行的商品($val[9])数量不正确";
                continue;
            }
            $name = trim($val[0]);
            if (!isset($data[$name]))
                $data[$name] = $val;
            if (isset($data[$name]['goods'][$val[8]])) {
                $data[$name]['goods'][$val[8]]['goods_number'] += round($val[10]);
            } else {
                $data[$name]['goods'][$val[8]] = [
                    'goods_id' => $val[8],
                    'goods_name' => $val[9],
                    'goods_number' => round($val[10]),
                    'remark' => $val[11],
                    'goods_image' => $member_goods['goods_image'],
                    'price' => round($val[12], 2),
                ];
            }
        }
        $this->geterror = $error;
        return $data;
    }

    public function checkGoodsPrice($member_goods_id)
    {
        return MemberGoods::detail($member_goods_id);
    }

    public function map(){
        return $this->fetch('map');
    }

}