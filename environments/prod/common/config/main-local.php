<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=rdsuoej93v8pnl568w2tj.mysql.rds.aliyuncs.com;dbname=smart_city',
            'username' => 'smart_city',
            'password' => 'cdc123123',
            'charset' => 'utf8',
            'emulatePrepare' => true,
            'tablePrefix' => 'cd_',
            'enableSchemaCache' => true,
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 3600,
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
//            'username' => '5466a6462f5d4d7e',
//            'password' => 'cdc123123SmartyCity',
            'serializer' => extension_loaded('igbinary') ? array('igbinary_serialize', 'igbinary_unserialize') : null,
            'useMemcached' => extension_loaded('memcached'),
            'keyPrefix' => 'wabao_',
            'options' => array(
                Memcached::OPT_SERIALIZER => extension_loaded('igbinary') ? Memcached::SERIALIZER_IGBINARY : Memcached::SERIALIZER_PHP,
            ),
            'servers' => [
                [
                    'host' => '5466a6462f5d4d7e.m.cnhzaliqshpub001.ocs.aliyuncs.com',
                    'port' => 11211,
                    'weight' => 100,
                    'timeout' => 3,
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];