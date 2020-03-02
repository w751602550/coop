<?php

namespace app\store\model\shopgh;


class GoodsImages extends ShopModel
{
    protected $pk = 'goods_image_id';

    public function getList($goods_commonid){
        return $this->where('goods_commonid',$goods_commonid)->select();
    }
}