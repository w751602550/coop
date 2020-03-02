<?php


namespace app\home\model;

use think\Db;

use think\facade\Session;

class Member extends BaseModel
{
    public function setPasswordAttr($value)
    {
        return pwd_hash($value);
    }

    public function detail($condition = [])
    {
        return $this->where($condition)->find();
    }

    public function checkLogin($data)
    {
        $member = $this->detail(['member_name|phone' => $data['member_name']]);
        if (!$member) {
            $this->error = '用户名不存在';
            return false;
        }
        if ($member['password'] != pwd_hash($data['password'])) {

          $this->error = '密码错误,请重新输入';
            return false;
        }
        if ($member['status'] != 1) {
            $this->error = '当前状态己被锁定，请联系管理员';
            return false;
        }
        $this->memberState($member);
        return true;
    }
	
	//新增用户
	public function addmember($data){
		
		$member = $this->detail(['member_name|phone' => $data['member_name']]);
		
		if ($member) {
           
			$this->error = '用户名已存在';
           
		    return false;
        }
		$pwd =pwd_hash($data['password']);
		
		
		 $addmember = [
			
			'member_name'=>$data['member_name'],
			
			'store_id'=>'1',
			
			'password' =>$pwd,
			
			'true_name'=>'东莞监狱',
			
			'create_time'=>time(),
		 ];
		
		$add =Db('member')->insert($addmember);
		
		return true;
		
		
	}
       //更改用户密码
	public function updatepwd($member){
		
		$pwd = pwd_hash($member['pwd']);
		
		$newpwd = pwd_hash($member['newpwd']);
		
		$name = $member['name'];
		
		$user =Db('member')->where('member_name',$name)->where('password',$pwd)->select();	
		
		if (!$user) {
            
			$this->error = '用户密码错误';
			
            return false;
        }
		
		$data =[
		
			'password'=>$newpwd,
		
		];
		
		$newuser =Db('member')->where('member_name',$name)->update($data);	
		
		return true;
		
	}

    public function memberState($member)
    {
        $session = [
            'member' => [
                'member_id' => $member['member_id'],
                'member_name' => $member['member_name'],
            ],
            'is_login' => 'true'
        ];
        Session::set(MEMBER, $session);
    }
}