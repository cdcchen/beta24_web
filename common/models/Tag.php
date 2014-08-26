<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_tag".
 *
 * @property string $id
 * @property integer $preset
 * @property string $name
 * @property integer $question_count
 * @property string $desc
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_TAG;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preset', 'question_count'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 250],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preset' => 'Preset',
            'name' => 'Name',
            'question_count' => 'Question Count',
            'desc' => 'Desc',
        ];
    }
}
