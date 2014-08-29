<?php
return [
    'language' => 'zh_CN',
    'sourceLanguage' => 'zh_CN',
    'charset' => 'UTF-8',
    'timeZone' => 'Asia/Shanghai',
    'version' => '1.0.0',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
