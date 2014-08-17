<?php

namespace app\behaviors;

use yii\db\BaseActiveRecord;

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
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAtAttribute, $this->updatedAtAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return $this->value !== null ? call_user_func($this->value, $event) : time();
        }
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
}