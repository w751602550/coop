<?php


namespace app\store\controller;


use app\binback\model\Log;
use think\facade\Session;
use app\store\model\Store as storeModel;

class Store extends Base
{
    public function login()
    {
        if ($this->ajax) {
            $post = postData('store');
            if (!captcha_check($post['captcha']))
                return ajaxError('验证码错误');
            $model = new storeModel();
            if ($model->login($post))
                return ajaxSuccess('登录成功', url('goods/index'));
            return ajaxError($model->getError() . '登录失败', url('admin/login'));
        }
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    public function logout()
    {
        Session::delete(STORE);
        $this->redirect('store/login');
    }
}