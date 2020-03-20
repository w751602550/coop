<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/3 0003
 * Time: 下午 17:09
 */

namespace app\fd\model;

use think\facade\Session;
class Finance extends BaseModel
{
    public function login($data)
    {
        if (!$admin = $this->checkLogin($data['account'], $data['password'])) {
            $this->error = '登录失败, 用户名或密码错误';
            return false;
        }
        $this->loginState($admin);
        return true;
    }

    protected function checkLogin($account, $password)
    {
        return $this->where([
            'member_name' => $account,
            'password' =>pwd_hash($password),
        ])->find();
    }

    protected function loginState($store){
        Session::set(FD,[
            'finance'=>[
                'member_id'=>$store['member_id'],
                'member_name'=>$store['member_name'],
            ],
            'is_login'=>true,
        ]);
    }
}