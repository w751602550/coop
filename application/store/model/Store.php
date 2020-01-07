<?php


namespace app\store\model;


class Store extends BaseModel
{
    protected function base($query){
        $query->where('store_id',$this->store_id);
    }

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
        return self::useGlobalScope(false)->where([
            'account' => $account,
            'password' =>pwd_hash($password),
            'is_delete' => 0,
        ])->find();
    }
}