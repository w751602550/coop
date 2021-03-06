<?php


namespace app\store\model;

use think\Db;

class MemberGoods extends Store
{
    public $pk = 'member_goods_id';

    public function goods()
    {
        return $this->hasOne('goods', 'goods_id', 'goods_id');
    }

    public function getPage($condition = [])
    {
        return $this->where($condition)->order('update_time desc')->paginate($this->psize);
    }

    public function getAll($condition = [])
    {
        return $this->where($condition)->all();
    }

    public function getMemberGoodsId($member_id)
    {
        return $this->where('member_id', $member_id)->column('goods_id');
    }

    public function updateCoop($data, $condition)
    {
        return $this->where($condition)->update($data);
    }

    public function add($goods, $member_id)
    {
        $memberGoodsList = $this->getMemberGoodsId($member_id);
        $data = [];
        if (is_array($goods)) {
            foreach ($goods as $key => $val) {
                if (in_array($val, $memberGoodsList))
                    continue;
                $supper_goods = (new Goods)->detail($val);
                $data[$key]['store_id'] = $this->store_id;
                $data[$key]['goods_id'] = $val;
                $data[$key]['member_id'] = $member_id;
                $data[$key]['price'] = $supper_goods['goods_price'];
                $data[$key]['name'] = $supper_goods['goods_name'];
                $data[$key]['thumb'] = $supper_goods['goods_image'];
                $data[$key]['unit'] = $supper_goods['unit'];
                $data[$key]['unit_name'] = $supper_goods['unit_name'] ?: '';
                $data[$key]['spec'] = $supper_goods['goods_spec'];
                $data[$key]['last_update'] = strtotime($supper_goods['update_time']);
            }
            return $this->saveAll($data);
        }
        if (in_array($goods, $memberGoodsList)) {
            $this->error = '该商品己是合约商品';
            return false;
        }
        $supper_goods = (new Goods)->detail($goods);
        $data['store_id'] = $this->store_id;
        $data['goods_id'] = $goods;
        $data['member_id'] = $member_id;
        $data['price'] = $supper_goods['goods_price'];
        $data['name'] = $supper_goods['goods_name'];
        $data['thumb'] = $supper_goods['goods_image'];
        $data['unit'] = $supper_goods['unit'];
        $data['unit_name'] = $supper_goods['unit_name'] ?: '';
        $data['spec'] = $supper_goods['goods_spec'];
        $data['last_update'] = strtotime($supper_goods['update_time']);
        return $this->save($data);
    }

    //编辑合约商品
    public function edit($goods, $member_id, $goods_id)
    {

        $data = [

            'name' => $goods['name'],

            'price' => $goods['price'],

            'spec' => $goods['spec'],

            'unit_name' => $goods['unit_name']

        ];

        $this->updates($data, $goods_id, $member_id);

        return true;

    }

    //更新合约商品
    public function updates($data, $goods_id, $member_id)
    {
        Db('member_goods')->where('member_id', $member_id)->where('member_goods_id', $goods_id)->update($data);

    }


    public function setDelete($condition)
    {
        return $this->where($condition)->delete();
    }
}