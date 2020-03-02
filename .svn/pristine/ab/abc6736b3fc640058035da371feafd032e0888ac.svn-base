<?php


namespace app\store\controller;

use think\Controller;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;

class Base extends Controller
{
    protected $store;
    protected $controller;
    protected $action;
    protected $rounteUri;
    protected $group;
    protected $ajax;
    protected $setting;
    protected $allowAction = [
        'store/login',
    ];
    protected $notLayout = [
        'store/login',
    ];

    protected function initialize()
    {
        $this->store = Session::get(STORE);
        $this->getRounteInfo();
        $this->checkLogin();
        $this->layout();
    }

    protected function getRounteInfo()
    {
        $this->controller = toUnderScore($this->request->controller());
        $this->action = $this->request->action();
        $groupStr = strstr($this->controller, '.', true);
        $this->group = $groupStr !== false ? $groupStr : $this->controller;
        $this->rounteUri = $this->controller . '/' . $this->action;
        $this->ajax=$this->request->isAjax();
    }

    protected function checkLogin(){
        if(in_array($this->rounteUri,$this->allowAction)){
            return ;
        }
        if(!$this->store || !$this->store['is_login']){
            $this->redirect('store/login');
        }
    }

    protected function layout(){
        if (!in_array($this->rounteUri, $this->notLayout)) {
            $this->assign([
                'base_url' => base_url(),
                'store_url' => strstr(url('/store'),'.',true),
                'group' => $this->group,
                'rount_uri'=>$this->rounteUri,
                'menus' => $this->menus(),
                'store' => $this->store,
                'setting' => $this->setting,
                'version'=>'1.1',
                'request'=>Request::instance()
            ]);
        }
    }

    protected function menus(){
        return Config::get('menus.');
    }
}