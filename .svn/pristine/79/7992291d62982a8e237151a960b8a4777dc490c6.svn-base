<?php

namespace app\home\controller;

use think\Controller;
use think\facade\Session;


class Base extends Controller
{
    public $member;
    protected $controller;
    protected $action;
    protected $rounteUri;
    protected $group;
    protected $ajax;
    protected $post;
    protected $setting;
    protected $allowAction = [
        'member/login',
		'member/resign',
    ];
    protected $notLayout = [
        'member/login',
		'member/resign',
    ];

    public function initialize()
    {
        parent::initialize();
        $this->member = Session::get(MEMBER);
        $this->getRounteInfo();
        $this->checkLogin();
        $this->layout();
    }

    private function getRounteInfo()
    {
        $this->controller = toUnderScore($this->request->controller());
        $this->action = $this->request->action();
        $groupStr = strstr($this->controller, '.', true);
        $this->group = $groupStr !== false ? $groupStr : $this->controller;
        $this->rounteUri = $this->controller . '/' . $this->action;
        $this->ajax = $this->request->isAjax();
        $this->post=$this->request->isPost();
    }

    public function checkLogin()
    {
        if (in_array($this->rounteUri, $this->allowAction)) {
            return;
        }
        if (!$this->member || !$this->member['is_login']) {
            $this->redirect('member/login');
        }
    }

    protected function layout()
    {
        if (!in_array($this->rounteUri, $this->notLayout)) {
            $this->assign([
                'base_url' => $this->baseUrl(),
                'group' => $this->group,
                'rount_uri' => $this->rounteUri,
                'member' => $this->member,
                'menu' => $this->memberMenu(),
            ]);
        }
    }

    protected function baseUrl()
    {
        $subDir = str_replace('\\', '/', dirname($this->request->server('PHP_SELF')));
        return $this->request->scheme() . '://' . $this->request->host() . $subDir . ($subDir === '/' ? '' : '/');
    }

    public function __call($name, $arguments)
    {
        return false;
    }

    public function memberMenu()
    {
        $menu = [
            [
                'name' => 'goods',
                'icon' => '&#xe709;',
                'text' => '商品管理',
                'url' => '',
                'submenu' => [
                    ['name' => '', 'text' => '合约商品', 'url' => 'memberGoods/index',],
                    ['name' => '', 'text' => '供应商品', 'url' => 'goods/index',],
                    ['name'=>'','text'=>'商品分类','url'=>'memberGoods.category/index'],
                ]
            ],
            [
                'name' => 'info',
                'icon' => '&#xe702;',
                'text' => '资料管理',
                'url' => '',
                'submenu' => [
                    ['name' => '', 'text' => '帐户信息', 'url' => 'member.information/index',],
//                    ['name' => '', 'text' => '帐户安全', 'url' => '',],
                    ['name' => '', 'text' => '收货地址', 'url' => 'member.address/index',],
                    ['name' => '', 'text' => '发票管理', 'url' => 'member.invoice/index',],
//                    ['name' => '', 'text' => '我的消息', 'url' => '',],
                ]
            ],
            [
                'name' => 'info',
                'icon' => '&#xe65c;',
                'text' => '交易管理',
                'url' => '',
                'submenu' => [
//                    ['name' => '', 'text' => '对帐单', 'url' => 'account/index',],
                    ['name' => '', 'text' => '订单管理', 'url' =>'order/index'],
                    ['name' => '', 'text' => '批量订单', 'url' => 'order/import'],
                ]
            ],
            [
                'name' => 'server',
                'icon' => '&#xe73f;',
                'text' => '客户服务',
                'url' => '',
                'submenu' => [
                    ['name' => '', 'text' => '缓存记录', 'url' => 'memberGoods/record',],
                ]
            ]
        ];
        return $menu;
    }
}
