<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/3 0003
 * Time: 下午 16:34
 */

namespace app\fd\controller;


use app\fd\model\Finance;

class Index extends Base
{
    public function index()
    {
       return redirect('order/index');
    }

    public function login()
    {
        if ($this->ajax) {
            $post = postData('store');
            if (!captcha_check($post['captcha']))
                return ajaxError('验证码错误');
           $model=new Finance;
            if ($model->login($post))
                return ajaxSuccess('登录成功', url('order/index'));
            return ajaxError($model->getError() . '登录失败', url('index/login'));
        }
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    public function logout()
    {
        Session::delete(FD);
        $this->redirect('index/login');
    }
}