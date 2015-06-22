<?php

require(__DIR__ . '/const.php');
require(__DIR__ . '/const-local.php');

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');

Yii::setAlias('staticRoot', dirname(dirname(__DIR__)) . '/static');
Yii::setAlias('static', DOMAIN_STATIC);
