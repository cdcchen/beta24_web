<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-8-28
 * Time: 下午9:05
 */

namespace common\base;


trait DateTimeTrait
{
    /**
     * return model's created_at text
     * @param null|string $format
     * @return string
     */
    public function getCreatedAt($format = null)
    {
        if (empty($format))
            $format = 'Y-m-d H:i:s';
        return empty($this->created_at) ? '' : date($format, $this->created_at);
    }

    /**
     * return model's created_at text
     * @param null|string $format
     * @return string
     */
    public function getUpdatedAt($format = null)
    {
        if (empty($format))
            $format = 'Y-m-d H:i:s';
        return empty($this->updated_at) ? '' : date($format, $this->updated_at);
    }
}