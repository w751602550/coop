<?php


namespace app\store\model;


use think\facade\Session;
use think\Model;

class BaseModel extends Model
{
    protected $store;
    protected $psize = 15;
    protected $sell_id;
    protected $store_id;
    public $gh_image;

    public function initialize()
    {
        parent::initialize();
        $this->store = Session::get(STORE);
        $this->sell_id=$this->store['store']['sell_id'];
        $this->store_id=$this->store['store']['store_id'];
        $this->gh_image =config('gh_image').$this->sell_id.'/';
    }

    protected function loginState($store){
        Session::set(STORE,[
            'store'=>[
                'store_id'=>$store['store_id'],
                'store_name'=>$store['store_name'],
                'sell_id'=>$store['sell_id']
            ],
            'is_login'=>true,
        ]);
    }
}