<?php


namespace app\home\controller;

use app\home\model\Goods as goodsModel;
use app\home\model\MemberGoods;

class Goods extends Base
{
    public function index($keywords = '')
    {
        if ($this->ajax) {
            $post = postData('goods');
            if (!$post)
                return ajaxError(getchina('noData'));
            foreach ($post as $key => $val) {
                $memberGoods=(new MemberGoods)->checkExists($val);
                if($memberGoods)
                unset($post[$key]);
            }
            $goodsArr=[];
            foreach ($post as $key =>$val){
                $goods=(new goodsModel)->getOne(['goods_id'=>$val]);
                $goodsArr[$key]['store_id'] = $goods['store_id'];
                $goodsArr[$key]['name']=$goods['goods_name'];
                $goodsArr[$key]['thumb']=$goods['goods_image'];
                $goodsArr[$key]['goods_id'] = $goods['goods_id'];
                $goodsArr[$key]['member_id'] = $this->member['member']['member_id'];
                $goodsArr[$key]['price'] = $goods['goods_price'];
            }
           if((new MemberGoods)->saveAll($goodsArr))
               return ajaxSuccess(getchina('addSuccess'),url('index'));
           return ajaxError(getchina('addError'));
        }
        $condition = [];
        $keywords && $condition[] = ['goods_name', 'like', '%' . trim($keywords) . '%'];
        $list = (new goodsModel)->getpage($condition);
        $goodsIdList = (new MemberGoods)->getGoodsIdList();
        return $this->fetch('index', compact('list', 'goodsIdList', 'keywords'));
    }
}