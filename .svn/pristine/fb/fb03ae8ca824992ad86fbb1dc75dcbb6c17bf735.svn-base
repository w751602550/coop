<?php

namespace app\home\controller;

use app\home\model\Member as memberModel;
use think\facade\Session;

class Member extends Base
{

    public function index()
    {
        return $this->fetch('index');
    }

    public function login()
    {
        if ($this->ajax) {
            $post = postData('member');
            $model=new memberModel();
            if($model->checkLogin($post))
                return ajaxSuccess(getchina('loginSuccess'),url('index/index'));
            return ajaxError(getchina('loginError').':'.$model->getError());
        }
        return $this->fetch('login');
    }

    public function logout(){
        Session::delete(MEMBER);
        $this->redirect('member/login');
    }
	
	//注册页面
	public function resign(){
		 
		 if ($this->ajax) {
            
			$post = postData('member');
           
			$model=new memberModel();
            
			if($model->addmember($post))
			
			return ajaxSuccess(getchina('addSuccess'),url('member/login')); //返回成功信息和跳转页面
			
			return ajaxError(getchina('loginError').':'.$model->getError());//返回失败信息
		 
		 $this->success('用户注册成功');
        
		}
		
		return $this->fetch('member/resign');
		
	}
       //用户更改密码
	public function resetpwd(){
		
		if ($this->ajax) {
            
			$post = postData('member');
           
			$model=new memberModel();
            
			if($model->updatepwd($post))
			
			return ajaxSuccess(getchina('updateSuccess'),url('member/resetpwd')); //返回成功信息和跳转页面
			
			return ajaxError(getchina('updateError').':'.$model->getError());//返回失败信息
			
		}
		
		return $this->fetch('member/resetpwd');
		
	}
}
