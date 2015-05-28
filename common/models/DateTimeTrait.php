<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-8-28
 * Time: 下午9:05
 */

namespace common\models;

/**
 * Class DateTimeTrait
 * @package common\base
 *
 * @property int $created_at
 * @property int $updated_at
 */
trait DateTimeTrait
{
    /**
     * return model's created_at text
     * @param null|string $format
     * @return string
     */
    public function getCreatedAt($format = null)
    {
        return $this->created_at ? formatter()->asDatetime($this->created_at, $format) : '';
    }

    /**
     * return model's created_at text
     * @param null|string $format
     * @return string
     */
    public function getUpdatedAt($format = null)
    {
        return $this->updated_at ? formatter()->asDatetime($this->updated_at, $format) : '';
    }
}
