<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_advert_slot".
 *
 * @property integer $id
 * @property string $name
 * @property string $solt_token
 * @property integer $width
 * @property integer $height
 * @property string $intro
 * @property integer $status
 *
 * @property AdvertDelivery[] $advertDeliveries
 */
class AdvertSlot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_ADVERT_SLOT;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['width', 'height', 'status'], 'integer'],
            [['name', 'solt_token'], 'string', 'max' => 50],
            [['intro'], 'string', 'max' => 250],
            [['name'], 'unique'],
            [['solt_token'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'solt_token' => 'Solt Token',
            'width' => 'Width',
            'height' => 'Height',
            'intro' => 'Intro',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertDeliveries()
    {
        return $this->hasMany(AdvertDelivery::className(), ['slot_id' => 'id']);
    }
}
