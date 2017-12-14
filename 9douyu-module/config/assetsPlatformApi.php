<?php

return [

    'sign'  => 'e825d5edb5dj28a9',

    'order' => [
        'send'    => [
            'url'        => '/interData/importOrder.shtml',
            'functionId' => 'importOrder'
        ],

        # 查询订单累计收益
        'orderInterest' => [
            'url'       => '/interData/orderInterest.shtml',
            'functionId'=> 'orderInterest'
        ],

        # 查询订单每日收益
        'orderInterestItem' => [
            'url'           => '/interData/orderInterestItem.shtml',
            'functionId'    => 'orderInterestItem'
        ],

        # 查询订单匹配债权
        'orderMatchCredit' => [
            'url'           => '/interData/orderMatchCredit.shtml',
            'functionId'    => 'orderMatchCredit'
        ],

        # 订单赎回申请
        'orderApplyRefund' => [
            'url'           => '/interData/redeemOrder.shtml',
            'functionId'    => 'redeemOrder'
        ],
    ],
    //项目对应债权信息的接口
    'project_credit' => [
        'get'     =>  [
            'url'            => '/interData/projectCredit.shtml',
            'functionId'     => 'projectCredit',
        ],
    ],
    //订单历史收益查询接口
    'order_interest' => [
        'get'     =>  [
            'url'            => '/interData/orderInterest.shtml',
            'functionId'     => 'orderInterest',
        ],
    ],
    //订单收益统计查询接口
    'order_total_interest' => [
        'get'     =>  [
            'url'            => '/interData/orderInterestSum.shtml',
            'functionId'     => 'orderInterestSum',
        ],
    ],

];

