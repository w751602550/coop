<?php


namespace app\store\model\shopgh;


use think\facade\Request;

class Goods extends ShopModel
{
    protected $pk = 'goods_id';

    public function common()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\' . ucfirst('goodsCommon'), 'goods_commonid', 'goods_commonid')->bind(['category_name' => 'gc_name', 'goods_body' => 'goods_body']);
    }

    public function getGoodsStateAttr($value)
    {
        $status = [
            '0' => '下架',
            '1' => '上架',
            '10' => '违规'
        ];
        return ['text' => $status[$value], 'value' => $value];
    }

    public function getList()
    {
        return $this->where('store_id', 8811)->select();
    }

    public function getPage()
    {
        return $this->where('store_id', $this->sell_id)->paginate($this->psize,false,['query'=>Request::instance()->request()]);
    }

    public function getAll()
    {
        return $this->where('store_id', $this->sell_id)->all();
    }

    public function detail($key)
    {
        return $this->with('common')->get($key);
    }
}