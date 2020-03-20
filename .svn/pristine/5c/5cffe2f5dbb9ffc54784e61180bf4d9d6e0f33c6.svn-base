<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/3 0003
 * Time: 下午 17:56
 */

namespace app\fd\model;

use think\facade\Request;
class Order extends BaseModel
{
    protected $pk = 'order_id';
    protected $append = ['payment_type_name'];

    public function member()
    {
        return $this->hasOne('Member', 'member_id', 'member_id')->bind('member_name');
    }

    public function goods()
    {
        return $this->hasMany('OrderGoods');
    }

    public function address()
    {
        return $this->hasOne('OrderAddress');
    }

    public function getPaymentTypeNameAttr($value, $data)
    {
        $text = [
            '0' => '',
            'month' => '月结',
            'online' => '现结',
        ];
        return $text[$data['payment_type']];
    }

    public function getPage($condition = [])
    {
        return $this->with('member')->where($condition)->order('update_time desc')->paginate($this->psize, false, ['query' => Request::instance()->request()]);
    }

    public function detail($key)
    {
        return self::with('member,goods,address')->get($key);
    }

    public static function getOne($condition = [])
    {
        return self::get($condition);
    }

    public function getAll($condition = [])
    {
        return self::with('address')->where($condition)->all();
    }
}