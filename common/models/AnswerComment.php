<?php

namespace common\models;

use common\behaviors\IPAddressBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cd_answer_comment".
 *
 * @property integer $id
 * @property integer $answer_id
 * @property integer $user_id
 * @property integer $created_at
 * @property string $created_ip
 * @property integer $score
 * @property string $content
 *
 * @property \common\models\User $user
 */
class AnswerComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_ANSWER_COMMENT;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_id', 'user_id'], 'required'],
            [['answer_id', 'user_id', 'created_at', 'score'], 'integer'],
            [['content'], 'string'],
            [['created_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answer_id' => '问题ID',
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

    /**
     * @inheritdoc
     * @return AnswerCommentQuery|ActiveQuery
     */
    public static  function find()
    {
        return new AnswerCommentQuery(get_called_class());
    }


    /******************** Relational Data ***********************/

    /**
     * AnswerComment has_one Answer via Answer.id -> answer_id
     * @return AnswerQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'answer_id'])
            ->inverseOf('comments');
    }

    /**
     * AnswerComment has_one User via user.id -> user_id
     * @return UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->inverseOf('answerComments');
    }
}


class AnswerCommentQuery extends ActiveQuery
{
    public function setAnswerID($id)
    {
        $this->andWhere('answer_id = :answer_id', [':answer_id' => $id]);
        return $this;
    }

    public function setUserID($id)
    {
        $this->andWhere('user_id = :user_id', [':user_id' => $id]);
        return $this;
    }
}