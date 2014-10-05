<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => '24beta_',
        ],
        'formatter' => [
            'class' => 'yii2plus\i18n\Formatter',
            'timeZone' => 'Asia/Shanghai',
        ],
    ],
];
