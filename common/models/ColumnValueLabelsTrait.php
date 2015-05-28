<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/4/26
 * Time: 下午10:37
 */

namespace common\models;

trait ColumnValueLabelsTrait
{
    public static function valueLabels($labels, $value, $exclude)
    {
        $exclude = (array)$exclude;
        if ($value === null)
            return empty($exclude) ? $labels : array_diff_key($labels, $exclude);
        else
            return $labels[$value];
    }
}