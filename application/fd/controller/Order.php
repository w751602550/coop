<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/3 0003
 * Time: 下午 17:00
 */

namespace app\fd\controller;

use app\fd\model\Order as orderModel;
use app\fd\model\Member as memberModel;

class Order extends Base
{
    protected $data = [
        '10' => '待审核',
        '15' => '待付款',
        '18' => '待确认',
        '20' => '待发货',
        '30' => '己发货',
        '40' => '己送达',
        '50' => '己完成',
        '60' => '己关闭',
    ];

    public function index($order_sn = '', $member_id = '', $status = '')
    {
        $condition = [];
        $order_sn && $condition['order_sn'] = trim($order_sn);
        $status && $condition['status'] = $status;
        $member_id && $condition['member_id'] = $member_id;
        $list = (new orderModel)->getPage($condition);
        $statusList = $this->data;
        $member = (new memberModel)->getAll();
        return $this->fetch('index', compact('list', 'statusList', 'member'));
    }

    public function show($order_id)
    {
        $model = new OrderModel;
        $order = $model->detail($order_id);
        $status = $this->data;
        return $this->fetch('show', compact('status', 'order'));
    }

    public function download($order_id)
    {
        $data = (new orderModel)->detail($order_id);
        $filename = '订单' . $data['order_sn'] . '_' . date('s', time()) . '.xlsx';
        $title = ['ID', '名称', '数量', '价格', '备注', '小计'];
        $objPHPExcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', '订单：' . $data['order_sn']);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->mergeCells('A2:C2');
        $sheet->setCellValue('A2', '客户名称：' . $data['member_name']);
        $sheet->mergeCells('D2:F2');
        $sheet->setCellValue('D2', '下单时间：' . $data['create_time']);
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A3', '付款总价：' . $data['pay_price']);
        $sheet->mergeCells('C3:F3');
        $sheet->setCellValue('C3', '收件人：' . $data['address']['name'].'('.$data['address']['phone'].')');
        $sheet->mergeCells('A4:F4');
        $sheet->setCellValue('A4', '收件地址：' . $data['address']['address']);
        $sheet->mergeCells('A5:F5');
        $sheet->setCellValue('A5', '商品信息');
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('A5')->getFont()->setSize(18);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $start = 'A';
        foreach ($title as $key => $val) {
            $sheet->setCellValue(chr(ord($start) + $key) . '6', $val);
        }
        $goods = [];
        foreach ($data['goods'] as $key => $val) {
            $goods[$key][] = $val['member_goods_id'];
            $goods[$key][] = $val['goods_name'];
            $goods[$key][] = $val['price'];
            $goods[$key][] = $val['number'];
            $goods[$key][] = $val['remark'];
            $goods[$key][] = $val['total_price'];
        }
        foreach ($goods as $key => $val) {
            foreach ($title as $k => $v) {
                $sheet->setCellValue(chr(ord($start) + $k) . ($key + 7), $val[$k]);
            }
        }
        ob_end_clean();
        header('pragma:public');
        header("Content-Disposition:attachment;filename=" . $filename);
        $objWriter->save('php://output');
        exit;
    }

    public function export($order_sn = '', $member_name = '', $status = '')
    {
        $condition = [];
        $order_sn && $condition[] = ['order_sn', '=', trim($order_sn)];
        $status && $condition[] = ['status', '=', intval($status)];
        if (trim($member_name)) {
            $member_name = '%' . str_replace(' ', '%', trim($member_name)) . '%';
            $con[] = ['member_name', 'like', $member_name];
            $memberIdArr = (new Member)->getIdByCon($con);
            $condition[] = ['member_id', 'in', $memberIdArr];
        }
        $model = new OrderModel;
        $list = $model->getAll($condition);
        if (!$list)
            return ajaxError(getchina('noData'));
        $filename = '订单列表' . date('mdHis', time()) . '.xlsx';
        $title = ['订单号', '客户名称', '联系电话', '联系地址', '付款方式', '总价', '订单状态', '下单时间', '发货时间', '完成时间'];
        $data = [];
        foreach ($list as $k => $v) {
            $data[$k][] = ($v['order_sn']) . ' ';
            $data[$k][] = $v['address']['name'];
            $data[$k][] = $v['address']['phone'];
            $data[$k][] = $v['address']['first_address'] . $v['address']['address'];
            $data[$k][] = $v['payment_type_name'];
            $data[$k][] = $v['total_price'];
            $data[$k][] = $this->data[$v['status']];
            $data[$k][] = $v['create_time'];
            $data[$k][] = $v['delivery_time'] ?: '';
            $data[$k][] = $v['complete_time'] ?: '';
        }
        return $this->exportExcel($filename, $title, $data);
    }

    public function exportOrder()
    {
        $order_id = postData('order_id');
        if (!$order_id)
            return ajaxError(getchina('deleteError'));
        $con[] = ['order_id', 'in', $order_id];
        $list = (new OrderModel)->getAll($con);
        if (!$list)
            return ajaxError(getchina('noData'));
        $filename = '订单列表' . date('mdHis', time()) . '.xlsx';
        $title = ['订单号', '客户名称', '联系电话', '联系地址', '付款方式', '总价', '订单状态', '下单时间', '发货时间', '完成时间'];
        $data = [];
        foreach ($list as $k => $v) {
            $data[$k][] = ($v['order_sn']) . ' ';
            $data[$k][] = $v['address']['name'];
            $data[$k][] = $v['address']['phone'];
            $data[$k][] = $v['address']['first_address'] . $v['address']['address'];
            $data[$k][] = $v['payment_type_name'];
            $data[$k][] = $v['total_price'];
            $data[$k][] = $this->data[$v['status']];
            $data[$k][] = $v['create_time'];
            $data[$k][] = $v['delivery_time'] ?: '';
            $data[$k][] = $v['complete_time'] ?: '';
        }
        return $this->exportExcel($filename, $title, $data);
    }

    protected function exportExcel($filename, $title, $data)
    {
        $objPHPExcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $sheet = $objPHPExcel->getActiveSheet();
        $start = 'A';
        foreach ($title as $key => $val) {
            $sheet->setCellValue(chr(ord($start) + $key) . '1', $val);
        }
        foreach ($data as $key => $val) {
            foreach ($title as $k => $v) {
                $sheet->setCellValue(chr(ord($start) + $k) . ($key + 2), $val[$k]);
            }
        }
        ob_end_clean();
        header('pragma:public');
        header("Content-Disposition:attachment;filename=" . $filename);
        $objWriter->save('php://output');
        exit;
    }
}