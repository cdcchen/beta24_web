<?php
/**
 *
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-9-15
 * Time: 下午4:41
 */

namespace frontend\controllers;


use frontend\base\Controller;

class TagController extends  Controller
{
    public function init()
    {
        parent::init();

        $this->channel = CHANNEL_TAG;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
} 