<?php
/**
 * 后台菜单配置
 */
return [
    'index' => [
        'name' => '首页',
        'icon' => 'icon-home',
        'index' => 'index/index',
        'active' => true,
    ],
    'goods' => [
        'name' => '商品管理',
        'icon' => 'icon-goods',
        'index' => 'goods/index',
        'submenu' => [
            [
                'name' => '供应商品',
                'index' => 'goods/index',
            ],
            [
                'name' => '商城商品',
                'index' => 'goods/ghGoods',
            ],
            [
                'name' => '合约商品',
                'index' => 'member.goods/all_list',
            ],

            [
                'name' => '商品单位',
                'index' => 'goods.unit/index',
            ],
        ],
    ],
    'member' => [
        'name' => '合约商户',
        'icon' => 'icon-user',
        'index' => 'member/index',
    ],
    'order' => [
        'name' => '订单管理',
        'icon' => 'icon-order',
        'index' => 'order/all_list',
        'submenu' => [
            [
                'name' => '全部订单',
                'index' => 'order/all_list',
            ],
            [
                'name' => '待发货',
                'index' => 'order/delivery_list',
            ],
            [
                'name' => '待收货',
                'index' => 'order/receipt_list',
            ],
            [
                'name' => '待付款',
                'index' => 'order/pay_list',
            ],
            [
                'name' => '已完成',
                'index' => 'order/complete_list',

            ],
            [
                'name' => '已取消',
                'index' => 'order/cancel_list',
            ],

        ]
    ],


//    'content' => [
//        'name' => '内容管理',
//        'icon' => 'icon-wenzhang',
//        'index' => 'content.article/index',
//        'submenu' => [
//            [
//                'name' => '文章管理',
//                'active' => true,
//                'submenu' => [
//                    [
//                        'name' => '文章列表',
//                        'index' => 'content.article/index',
//
//                    ],
//                    [
//                        'name' => '文章分类',
//                        'index' => 'content.category/index',
//
//                    ],
//                ]
//            ],
//        ]
//    ],

];
