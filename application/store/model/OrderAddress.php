<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/21 0021
 * Time: 下午 19:57
 */

namespace app\store\model;


class OrderAddress extends BaseModel
{
    protected $pk = 'address_id';

    public function setDelete($order_id)
    {
        return $this->where('order_id', $order_id)->delete();
    }
}