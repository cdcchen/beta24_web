<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['account/login']
        ],
        'formatter' => [
            'class' => 'yiiplus\i18n\Formatter',
            'timeZone' => 'Asia/Shanghai',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'basePath' => '@staticRoot/assets',
            'baseUrl' => '@static/assets',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => ['http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js']
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => ['http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css']
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => ['http://apps.bdimg.com/libs/bootstrap/3.3.0/js/bootstrap.min.js']
                ],
                'yii\bootstrap\BootstrapThemeAsset' => [
                    'sourcePath' => null,
                    'css' => ['http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap-theme.min.css']
                ],
            ],
        ],
        'security' => [
            'passwordHashStrategy' => 'password_hash',
        ],
        'userConfig' => [
            'class' => 'yiiplus\config\UserConfig',
        ],
    ],
];
