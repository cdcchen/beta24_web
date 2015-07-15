<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/13
 * Time: 下午3:07
 */

namespace frontend\controllers;


use phpplus\net\CUrl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class ShadowsocksController extends Controller
{
    static public $servers = [
        '138.128.222.168' => [159293, 'private_T7Z2t0u4TB4AqevGFPJjJN8y'],
        '192.243.118.40' => [159612, 'private_J3REwg3t42ivgDOheIQIvRxB'],
        '45.78.1.243' => [180400, 'private_5p40axG0ZdcPDEcwQfiaz3Lq'],
    ];

    public function actionServiceInfo($ip)
    {
        $server = static::$servers[$ip];
        if (empty($server))
            throw new ForbiddenHttpException('无效请求');
            
        $url = sprintf('https://api.kiwivm.it7.net/v1/getServiceInfo?veid=%s&api_key=%s', $server[0], $server[1]);

        $http = new CUrl();
        $http->get($url);
        if ($http->getErrno() === 0) {
            response()->format = Response::FORMAT_HTML;
            $data = $http->getJsonData();
            $bytes = (int)$data['plan_monthly_data'] - (int)$data['data_counter'];

            return formatter()->asSizeNumber($bytes, 2, true);
        }
        else
            throw new ServerErrorHttpException('请求错误');
    }
}
