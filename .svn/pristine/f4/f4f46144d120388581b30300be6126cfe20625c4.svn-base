<?php


namespace app\store\model;


class GoodsImages extends Store
{
    protected $pk = 'image_id';

    public function addByGh($post, $goods_id)
    {
        $data = [];
        foreach ($post as $key => $val) {
            $data[$key]['url'] = $this->gh_image . $val['goods_image'];
            $data[$key]['store_id'] = $this->store['store']['store_id'];
            $data[$key]['goods_id'] = $goods_id;
        }
        return $this->allowField(true)->saveAll($data);
    }

    public function setDelete($condition)
    {
        return $this->where($condition)->delete();
    }
}