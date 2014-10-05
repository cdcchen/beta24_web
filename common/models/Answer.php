<?php

namespace common\models;

use common\base\DateTimeTrait;
use common\config\HtmlPurifierConfig;
use Yii;
use common\behaviors\IPAddressBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;

/**
 * This is the model class for table "cd_answer".
 *
 * @property string $id
 * @property string $question_id
 * @property string $user_id
 * @property integer $created_at
 * @property string $created_ip
 * @property integer $updated_at
 * @property string $updated_ip
 * @property integer $vote_up
 * @property integer $vote_down
 * @property integer $accepted
 * @property string $content
 *
 * __get property
 * @property string $createdAt
 * @property string $updatedAt
 * @property $userIsOwner
 * @property $url
 * @property string $purifyContent
 *
 * Relations
 * @property \common\models\User $user
 * @property array|\common\models\AnswerComment[] $comments
 * @property \common\models\Question $question
 */

class Answer extends \yii\db\ActiveRecord
{
    use DateTimeTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_ANSWER;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            IPAddressBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'content', 'user_id'], 'required'],
            [['question_id', 'user_id', 'created_at', 'updated_at', 'vote_up', 'vote_down'], 'integer'],
            [['accepted'], 'boolean'],
            [['content'], 'string'],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
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
            'created_at' => '回答时间',
            'created_ip' => '回答IP',
            'updated_at' => '更新时间',
            'updated_ip' => '更新IP',
            'vote_up' => '支持数',
            'vote_down' => '反对数',
            'accepted' => '最佳答案',
            'content' => '内容',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields['createdAt'] =  [$this, 'getCreatedAt'];
        $fields['updatedAt'] =  [$this, 'getUpdatedAt'];
        $fields['url'] =  [$this, 'getUrl'];
        $fields['purifyContent'] =  [$this, 'getPurifyContent'];

        return $fields;
    }

    /**
     * @inheritdoc
     * @return AnswerQuery|ActiveQuery
     */
    public static function find()
    {
        return new AnswerQuery(get_called_class());
    }


    /******************** __get Data ***********************/

    public function getUserIsOwner()
    {
        return $this->user_id == $this->question->user_id;
    }

    public function getUrl()
    {
        return Url::toRoute(['question/show', 'id'=>$this->question_id, '#'=>'answer-' . $this->id]);
    }

    public function getPurifyContent()
    {
        static $contents = [];
        if (!array_key_exists($this->id, $contents)) {
            $contents[$this->id] = HtmlPurifier::process($this->getParsedContent(), HtmlPurifierConfig::answer());
        }

        return $contents[$this->id];
    }

    public function getParsedContent()
    {
        static $contents = [];
        if (!array_key_exists($this->id, $contents)) {
            $contents[$this->id] = Markdown::process($this->content);
        }

        return $contents[$this->id];

    }

    /******************** Relational Data ***********************/

    /**
     * Answer has_one Question via Question.id -> question_id
     * @return QuestionQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id'])
            ->inverseOf('answers');
    }

    /**
     * Answer has_many AnswerComment via AnswerComment.answer_id -> id
     * @return AnswerCommentQuery
     */
    public function getComments()
    {
        return $this->hasMany(AnswerComment::className(), ['answer_id' => 'id'])
            ->inverseOf('answer');
    }

    /**
     * Answer has_one User via user.id -> user_id
     * @return UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->inverseOf('answers');
    }


    /******************** event methods ***********************/

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert && $this->question) {
            $this->question->answer_count++;
            $this->question->save(true, ['answer_count']);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if ($this->question) {
            $this->question->answer_count--;
            $this->question->save(true, ['answer_count']);
        }
    }
}


class AnswerQuery extends ActiveQuery
{
    public function setQuestionID($id)
    {
        $this->andWhere('question_id = :question_id', [':question_id' => $id]);
        return $this;
    }

    public function setUserID($id)
    {
        $this->andWhere('user_id = :user_id', [':user_id' => $id]);
        return $this;
    }
}
