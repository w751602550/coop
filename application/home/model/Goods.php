<?php


namespace app\home\model;


use think\facade\Request;

class Goods extends BaseModel
{
    protected $pk = 'goods_id';

    public function unit()
    {
        return $this->hasOne('GoodsUnit','id','unit')->bind(['unit_name'=>'name']);
    }

    public function getPage($condition = [])
    {
        $field = ['goods_id', 'goods_name', 'goods_price', 'goods_image', 'category_name','unit'];
        return $this->with('unit')->where($condition)->where('status', 1)->field($field)->paginate($this->psize, false, ['query' => Request::instance()->request()]);
    }

    public function getOne($condition = [])
    {
        return $this->where($condition)->where('status',1)->find();
    }

    public function detail($key){
        return self::with('unit')->get($key);
    }
}