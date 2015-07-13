<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14/11/24
 * Time: 下午12:11
 */

return [
    UM_FRONTEND => [
        'class' => 'yii\web\UrlManager',
        'baseUrl' => DOMAIN_FRONTEND,
        'enablePrettyUrl' => true,
        'enableStrictParsing' => false,
        'showScriptName' => false,
        'rules' => [
            '' => 'site/index',
            '<controller:(question|tag|user|badge)>s' => '<controller>/index',
            'questions/<id:\d+>' => 'question/show',

            'question/tagged/<name>' => 'question/tagged',

            'users/<id:\d+>/<name:[0-9a-zA-Z_\-\.\一-\龥]+>' => 'user/home',

        ],
    ],

    UM_BACKEND => [
        'class' => 'yii\web\UrlManager',
        'baseUrl' => DOMAIN_BACKEND,
        'enablePrettyUrl' => true,
        'enableStrictParsing' => false,
        'showScriptName' => false,
        'rules' => [
            '/' => 'site/index',
        ],
    ]
];
