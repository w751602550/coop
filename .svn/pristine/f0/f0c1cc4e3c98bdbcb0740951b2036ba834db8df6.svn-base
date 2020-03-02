<?php


namespace app\home\model;


use think\facade\Session;
use think\Model;

class BaseModel extends Model
{
    protected $member;
    protected $psize=10;
    protected $member_id;

    public function initialize()
    {
        parent::initialize();
        $this->member=Session::get(MEMBER);
        $this->member_id=$this->member['member']['member_id'];
    }

}