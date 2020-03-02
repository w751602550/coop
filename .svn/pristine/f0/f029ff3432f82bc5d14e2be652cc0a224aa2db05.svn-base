<?php


namespace app\store\controller;

use app\store\model\GoodsUnit;
use app\store\model\shopgh\Goods as ghGoods;
use app\store\model\Goods as goodsModel;

class Goods extends Base
{

    public function index()
    {
        $model = new goodsModel();
        $list = $model->getPage();
        $imageUrl = $model->gh_image;
        return $this->fetch('index', compact('list', 'imageUrl'));
    }

    public function edit($goods_id)
    {
        $detail = (new goodsModel)->detail($goods_id);
        if (!$detail)
            return ajaxError(getchina('noData'));
        if($this->ajax){
            $post=postData('goods');
            if($detail->updates($post,$goods_id))
                return ajaxSuccess(getchina('updateSuccess'));
            return ajaxError(getchina('updateError'));
        }
        $unit=(new GoodsUnit)->getAll();
        return $this->fetch('edit',compact('detail','unit'));
    }

    public function ghGoods()
    {
        $model = new ghGoods();
        $goodsModel = new goodsModel();
        $goodsIdList = $goodsModel->getGhGoodsId();
        if ($this->ajax) {
            $post = postData('goods');
            foreach ($post as $key => $val) {
                if (in_array($val, $goodsIdList))
                    continue;
                $gh_goods = $model->detail($val)->toArray();
                (new goodsModel)->import($gh_goods);
            }
            return ajaxSuccess(getchina('addSuccess'), url('goods/ghGoods'));
        }
        $list = $model->getPage();
        foreach ($list as $key => &$val) {
            in_array($val['goods_id'], $goodsIdList) && $val['is_supply'] = 1;
        }
        $imageUrl = $model->gh_image;
        return $this->fetch('ghindex', compact('list', 'imageUrl'));
    }

    public function addByGoodsId($goods_id)
    {
        if (!$this->ajax)
            return ajaxError('接口有误');
        $model = new goodsModel();
        if ($model->checkExist(['gh_goods_id' => $goods_id]))
            return ajaxError('该商品己存在供应库中');
        $gh_goods = (new ghGoods)->detail($goods_id)->toArray();
        if (!$gh_goods)
            return ajaxError('数据有误，请重试');
        if ($model->import($gh_goods))
            return ajaxSuccess(getchina('addSuccess'));
        return ajaxError(getchina('addError') . ':' . $model->getError());
    }

    public function addGhgoodAll()
    {
        $model = new goodsModel();
        $goodsIdList = $model->getGhGoodsId();
        $ghGoodsList = (new ghGoods)->getAll()->toArray();
        foreach ($ghGoodsList as $key => $val) {
            if (in_array($val['goods_id'], $goodsIdList)) {
                unset($ghGoodsList[$key]);
            }
        }
        if ($model->importAll($ghGoodsList))
            return ajaxSuccess(getchina('addSuccess'));
        return ajaxError(getchina('addError') . ':' . $model->getError());
    }


    public function delete($goods_id)
    {
        if ($this->ajax) {
            if ((new goodsModel)->setDelete($goods_id))
                return ajaxSuccess(getchina('deleteSuccess'), url('index'));
            return ajaxError(getchina('deleteError'));
        }
    }
}