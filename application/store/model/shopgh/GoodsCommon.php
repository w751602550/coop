<?php


namespace app\store\model\shopgh;


use think\facade\Request;

class GoodsCommon extends ShopModel
{
    protected $pk = 'goods_commonid';

    public function goods()
    {
        return $this->hasMany(__NAMESPACE__ . '\\' . ucfirst('goods'), 'goods_commonid', 'goods_commonid');
    }

    public function images(){
        return $this->hasMany(__NAMESPACE__.'\\'.ucfirst('goodsImages'),'goods_commonid','goods_commonid');
    }

    public function getPage($field='*'){
      return $this->with('goods')->field($field)->where('store_id',$this->sell_id)->paginate($this->psize,'false',['query'=>Request::instance()->request()]);
    }
}