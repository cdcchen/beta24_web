<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_advert_delivery".
 *
 * @property integer $id
 * @property integer $slot_id
 * @property integer $weight
 * @property integer $bizrule
 * @property string $intro
 * @property string $adcode
 * @property integer $status
 *
 * @property AdvertSlot $slot
 */
class AdvertDelivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_ADVERT_DELIVERY;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slot_id'], 'required'],
            [['slot_id', 'weight', 'bizrule', 'status'], 'integer'],
            [['adcode'], 'string'],
            [['intro'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slot_id' => 'Slot ID',
            'weight' => 'Weight',
            'bizrule' => 'Bizrule',
            'intro' => 'Intro',
            'adcode' => 'Adcode',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlot()
    {
        return $this->hasOne(AdvertSlot::className(), ['id' => 'slot_id']);
    }
}
