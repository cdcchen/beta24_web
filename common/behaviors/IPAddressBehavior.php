<?php

namespace common\behaviors;

use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;

class IPAddressBehavior extends AttributeBehavior
{
    public $createdIPAttribute = 'created_ip';

    public $updatedIPAttribute = 'updated_ip';

    public $value;

    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdIPAttribute, $this->updatedIPAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedIPAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        return $this->value !== null ? call_user_func($this->value, $event) : static::getUserIP();
    }

    /**
     * Updates a ip address attribute to the current ip address.
     *
     * ```php
     * $model->touch('last_ip');
     * ```
     * @param string $attribute the name of the attribute to update.
     */
    public function touch($attribute)
    {
        $this->owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }

    /**
     * Returns the user IP address.
     * @return string user IP address. Null is returned if the user IP address cannot be detected.
     */
    private static function getUserIP()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }
}