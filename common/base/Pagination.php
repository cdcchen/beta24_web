<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-9-8
 * Time: 下午3:55
 */

namespace common\base;

use yii;
use yii\web\Request;

class Pagination extends \yii\data\Pagination
{
    /**
     * Creates the URL suitable for pagination with the specified pageSize number.
     * This method is mainly called by pagers when creating URLs used to perform pagination.
     * @param integer $pageSize
     * @param boolean $absolute whether to create an absolute URL. Defaults to `false`.
     * @return string the created URL
     * @see params
     * @see forcePageParam
     */
    public function createPageSizeUrl($pageSize, $absolute = false)
    {
        if (($params = $this->params) === null) {
            $request = Yii::$app->getRequest();
            $params = $request instanceof Request ? $request->getQueryParams() : [];
        }

        $page = $this->getPage();
        if ($page > 0 || $page >= 0 && $this->forcePageParam) {
            $params[$this->pageParam] = $page + 1;
        } else {
            unset($params[$this->pageParam]);
        }

        $pageSize = ($pageSize > 0) ? (int)$pageSize : $this->getPageSize();
        if ($pageSize != $this->defaultPageSize) {
            $params[$this->pageSizeParam] = $pageSize;
        } else {
            unset($params[$this->pageSizeParam]);
        }
        $params[0] = $this->route === null ? Yii::$app->controller->getRoute() : $this->route;
        $urlManager = $this->urlManager === null ? Yii::$app->getUrlManager() : $this->urlManager;

        if ($absolute) {
            return $urlManager->createAbsoluteUrl($params);
        } else {
            return $urlManager->createUrl($params);
        }
    }
}