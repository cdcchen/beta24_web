<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/4/26
 * Time: 下午10:37
 */

namespace common\models;

trait QueryScopeTrait
{
    public function columnEqualOrIn($column, $value)
    {
        $value = (array)$value;
        if (isset($value[1]))
            $this->andWhere(['in', $column, $value]);
        else
            $this->andWhere([$column => $value[0]]);
    }
}