<?php


namespace app\home\model;


use think\facade\Request;

class MemberGoods extends BaseMember
{
    protected $pk = 'member_goods_id';

    public function category(){
        return $this->hasOne('MemberCategory','category_id','category_id')->bind(['category_name'=>'name']);
    }
    public function goods()
    {
        return $this->hasOne('goods', 'goods_id', 'goods_id')->bind(['goods_image' => 'goods_image', 'goods_name' => 'goods_name', 'category_name' => 'category_name']);
    }

    public function add($goods)
    {
        $memberGoods = [];
        $memberGoods['store_id'] = $goods['store_id'];
        $memberGoods['name']=$goods['goods_name'];
        $memberGoods['thumb']=$goods['goods_image'];
        $memberGoods['goods_id'] = $goods['goods_id'];
        $memberGoods['member_id'] = $this->member_id;
        $memberGoods['price'] = $goods['goods_price'];
        $memberGoods['unit']=$goods['unit'];
        $memberGoods['unit_name']=$goods['unit_name']?:'';
        $memberGoods['spec']=$goods['goods_spec'];
        $memberGoods['last_update']=strtotime($goods['update_time']);
        return $this->allowField(true)->save($memberGoods);
    }

    public function getpage($condition = [])
    {
        return $this->with('category')->where($condition)->order('update_time desc')->paginate($this->psize,false,['query'=>Request::instance()->request()]);
    }

    public function getAll($condition=[]){
        return $this->with('goods')->where($condition)->order('update_time desc')->all();
    }

    public function getGoodsIdList()
    {
        return $this->column('goods_id');
    }

    public static function detail($member_goods_id)
    {
        return self::with('goods')->get($member_goods_id);
    }

    public function checkExists($goods_id){
        return $this->where('goods_id',$goods_id)->find();
    }

    public function updateGoodsName(){
        $goodsList=$this->with('goods')->all()->toArray();

        foreach ($goodsList as $key => $val){
            $data=[];
            if(!$val['name'])
                $data['name']=$val['goods_name'];
            if(!$val['thumb'])
                $data['thumb']=$val['goods_image'];
            $this->update($data,['member_goods_id'=>$val['member_goods_id']]);
        }
      return true;
    }
}