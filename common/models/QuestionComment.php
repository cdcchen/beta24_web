<?php

namespace common\models;

use common\behaviors\IPAddressBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cd_question_comment".
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $user_id
 * @property integer $created_at
 * @property string $created_ip
 * @property integer $score
 * @property string $content
 * @property User $user
 * @property Question $question
 */
class QuestionComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_QUESTION_COMMENT;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'user_id', 'content'], 'required'],
            [['question_id', 'user_id', 'created_at', 'score'], 'integer'],
            [['created_ip'], 'string', 'max' => 15],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => '问题ID',
            'user_id' => '用户ID',
            'created_at' => '创建时间',
            'created_ip' => '创建IP',
            'score' => '评分',
            'content' => '内容',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => null,
                ],
            ],
            'ip_address' => [
                'class' => IPAddressBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_ip',
                    ActiveRecord::EVENT_BEFORE_UPDATE => null,
                ],
            ],
        ];
    }

    public static function find()
    {
        return new QuestionCommentQuery(get_called_class());
    }


    /******************** Relational Data ***********************/

    /**
     * QuestionComment has_one User via User.id -> user_id
     * @return UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->inverseOf('questionComments');
    }

    /**
     * QuestionComment has_one Question via Question.id -> question_id
     * @return QuestionQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id'])
            ->inverseOf('comments');
    }
}


class QuestionCommentQuery extends ActiveQuery
{
    /**
     * @param int $min
     * @param int $max
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function score($min, $max = 0)
    {
        $min = (int)$min;
        $max = (int)$max;

        if ($max === 0)
            $this->andWhere('score > :min', [':min' => $min]);
        elseif ($min >= (int)$max)
            throw new \InvalidArgumentException('Min must be less than max.');
        else
            $this->andWhere('between', 'score', $min, (int)$max);

        return $this;
    }
}