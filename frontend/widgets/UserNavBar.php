<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-9-16
 * Time: 上午1:35
 */

namespace frontend\widgets;

use \yii\helpers\Url;
use \yii\base\Widget;

class UserNavBar extends Widget
{
    public function init()
    {

    }


    public function run()
    {
        $html = '';
        if (user()->getIsGuest()) {
            $html .= a('登录', user()->loginUrl);
            $html .= a('注册', Url::toRoute('account/signup'));
        }
        else {
            $html .= a(user()->getIdentity()->getDisplayName(), Url::toRoute('account/home'));
            $html .= a('退出', Url::toRoute('account/logout'));
        }

        return $html;
    }
}