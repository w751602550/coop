<?php


namespace app\home\model;


use think\Db;
use think\facade\Request;

class Order extends BaseMember
{
    protected $pk = 'order_id';
    //10待审核20待发货30己发货40己送达50己付款60己完成70己关闭'
    public $data = [
        '10' => '待审核',
        '15' => '待付款',
        '18' => '待确认',
        '20' => '待发货',
        '30' => '己发货',
        '40' => '己送达',
        '50' => '己完成',
        '60' => '己关闭',
    ];

    protected function getStatusAttr($value)
    {
        $data = $this->data;
        return ['text' => $data[$value], 'value' => $value];
    }

    public function goods()
    {
        return $this->hasMany('orderGoods', 'order_id', 'order_id');
    }

    public function address()
    {
        return $this->hasOne('orderAddress', 'order_id', 'order_id');
    }

    public function getPage($condition = [])
    {
        return self::with('goods,address')->where($condition)->order('update_time desc')->paginate($this->psize, false, ['query' => Request::instance()->request()]);
    }

    public static function detail($order_id)
    {
        return self::with('goods,address')->get($order_id);
    }

    public function edit($data, $order_id)
    {
        return $this->allowField(true)->save($data, $order_id);
    }

    public function getAll($condition = [])
    {
        return $this->where($condition)->select();
    }

    public function buildOrder($data)
    {
        $time = time();
        Db::startTrans();
        try {
            foreach ($data as $key => $val) {
                $orderModel = new self();
                $orderGoodsModel = new OrderGoods;
                $addressModel = new OrderAddress;
                $order = [];
                $goodsArr = [];
                $address = [];
                $totalPrice = 0;
                $order['member_id'] = $this->member_id;
                $order['order_sn'] = $this->orderNo();
                $order['year'] = date('Y', $time);
                $order['month'] = date('m', $time);
                $orderModel->save($order);
                foreach ($val['goods'] as $item => $goods) {
                    $goodsArr[$item]['order_id'] = $orderModel->order_id;
                    $goodsArr[$item]['member_goods_id'] = $goods['goods_id'];
                    $goodsArr[$item]['goods_name'] = $goods['goods_name'];
                    $goodsArr[$item]['goods_image'] = $goods['goods_image'];
                    $goodsArr[$item]['number'] = $goods['goods_number'];
                    $goodsArr[$item]['price'] = $goods['price'];
                    $goodsArr[$item]['total_price'] = round($goods['goods_number'] * $goods['price'], 2);
                    $goodsArr[$item]['remark'] = $goods['remark'] ?: '';
                    $totalPrice += $goodsArr[$item]['total_price'];
                }
                $orderGoodsModel->saveAll($goodsArr);
                $address['order_id'] = $orderModel->order_id;
                $address['member_id'] = $this->member_id;
                $address['name'] = $val[0];
                $address['first_address'] = $val[1] . '-' . $val[2] . '-' . $val[3] . '-' . $val[4];
                $address['address'] = $val[5];
                $address['code'] = $val[6];
                $address['phone'] = $val[7];
                $addressModel->save($address);
                $this->update(['order_id' => $orderModel->order_id, 'total_price' => $totalPrice, 'pay_price' => $totalPrice]);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }

    protected function orderNo()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    public function payNo()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8) . sprintf('%05s', $this->member_id);
    }
}