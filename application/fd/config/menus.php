<?php
/**
 * 后台菜单配置
 */
return [
    'order' => [
        'name' => '订单管理',
        'icon' => 'icon-order',
        'index' => 'order/index',
        'submenu' => [
            [
                'name' => '全部订单',
                'index' => 'order/index',
            ],
        ]
    ],

];
