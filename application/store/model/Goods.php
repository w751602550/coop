<?php


namespace app\store\model;

use app\store\model\shopgh\GoodsImages as ghGoodsImage;
use think\Db;

class Goods extends Store
{
    protected $pk = 'goods_id';

    public function getStatusAttr($value)
    {
        $status = [
            '0' => '下架',
            '1' => '上架',
            '10' => '违规'
        ];
        return ['text' => $status[$value], 'value' => $value];
    }

    public function unit()
    {
        return $this->hasOne('GoodsUnit','id','unit')->bind(['unit_name'=>'name']);
    }

    public function image()
    {
        return $this->hasMany('GoodsImages', 'goods_id', 'goods_id');
    }

    public function getPage()
    {
        $field = ['goods_id', 'goods_name', 'goods_price', 'goods_marketprice', 'goods_image', 'unit', 'goods_spec','goods_edittime', 'category_name', 'status', 'update_time'];
        return $this->with('unit')->where('store_id', $this->store_id)->field($field)->paginate($this->psize);
    }

    public function add($data)
    {
        return $this->allowField(true)->save($data);
    }
     //更新商品数据
	public function updates($goods,$goods_id){

		$data =[			
			'goods_price'=>$goods['price'],			
			'goods_marketprice'=>$goods['marketprice'],			
			'status'=>$goods['status'],
			'goods_jingle'=>$goods['goods_jingle'],
			'goods_name'=>$goods['goods_name'],
			'goods_spec'=>$goods['goods_spec'],
			'unit'=>$goods['unit'],
			'goods_body'=>$goods['goods_body']
		
		];
		 
		return $upgoods =Db('goods')->where('goods_id',$goods_id)->update($data);
		
	}
    public function importAll($data)
    {
        if (!$data)
            return false;
        foreach ($data as $key => $val) {
            if ($this->import($val))
                continue;
        }
    }

    public function import($data)
    {
        $data['gh_goods_id'] = $data['goods_id'];
        unset($data['goods_id']);
        $data['gh_goods_commonid'] = $data['goods_commonid'];
        $data['store_id'] = $this->store['store']['store_id'];
        $data['goods_image'] = $this->gh_image . $data['goods_image'];
        $data['status'] = $data['goods_state']['value'];
        $goodsImages = (new ghGoodsImage)->getList($data['gh_goods_commonid']);
        Db::startTrans();
        try {
            $this->allowField(true)->save($data);
            (new GoodsImages)->addByGh($goodsImages, $this->goods_id);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }

    public function getGhGoodsId()
    {
        return $this->column('gh_goods_id');
    }


    public function checkExist($condition)
    {
        return $this->find($condition);
    }

    public function detail($key)
    {
        return self::with('image,unit')->get($key);
    }

    public function setDelete($goods_id)
    {
        Db::startTrans();
        try {
            $this->where(['goods_id' => $goods_id, 'store_id' => $this->store_id])->delete();
            (new GoodsImages)->setDelete(['goods_id' => $goods_id, 'store_id' => $this->store_id]);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }
}