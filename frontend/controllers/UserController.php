<?php
/**
 *
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-9-15
 * Time: 下午4:41
 */

namespace frontend\controllers;


use yii\web\Controller;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\bootstrap\BootstrapThemeAsset;

class UserController extends  Controller
{
    public function init()
    {
        parent::init();

        $this->view->params['channel'] = CHANNEL_USER;
    }

    public function actionIndex()
    {
        BootstrapAsset::className();
        BootstrapPluginAsset::className();
        BootstrapThemeAsset::className();
        return $this->render('index');
    }

    public function actionHome()
    {
        return $this->render('index');
    }
} 