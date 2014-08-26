<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "cd_tag".
 *
 * @property integer $id
 * @property integer $preset
 * @property string $name
 * @property integer $question_count
 * @property string $desc
 *
 * @property array|Question[] $questions
 */
class Tag extends \yii\db\ActiveRecord
{
    const PRESET_YES = 1;
    const PRESET_NO = 0;

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
            [['name'], 'required'],
            [['preset', 'question_count'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 250],
            [['name', 'desc'], 'filter', 'filter'=>'trim'],
            [['name', 'desc'], 'filter', 'filter'=>'strip_tags'],
            [['preset'], 'in', 'range' => [self::PRESET_YES, self::PRESET_NO]],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preset' => '预定义',
            'name' => '名称',
            'question_count' => '问题数',
            'desc' => '备注',
        ];
    }

    /**
     * @inheritdoc
     * @return TagQuery|ActiveQuery
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }


    /******************** Relational Data ***********************/

    /**
     * Tag has_many Question via Question.id -> question_tag.question_id and question_tag.tag_id -> id
     * @return QuestionQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])
            ->viaTable(TBL_QUESTION_TAG, ['tag_id' => 'id']);
    }
}


class TagQuery extends ActiveQuery
{
    public function search($kw, $or = true)
    {
        $this->andWhere([$or ? 'or like' : 'like', 'name', $kw]);
        return $this;
    }

    public function preset($preset = true)
    {
        $this->andWhere('preset = :preset', [':preset' => $preset ? Tag::PRESET_YES : Tag::PRESET_NO]);
        return $this;
    }
}