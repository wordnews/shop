<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cacheFileSuffix' => '.php',
            'cachePath' => '@frontend/runtime/cache'
        ],

        /* 格式化日期的组件 */
        'formatter' => [
            'locale'=>'zh-CN',
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm',
        ],
    ],

    'language' => 'zh-CN', // 设置语言
];
