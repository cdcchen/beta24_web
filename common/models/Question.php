<?php

namespace common\models;

use DateTime;
use common\base\DateTimeTrait;
use common\behaviors\IPAddressBehavior;
use Yii;
use yii\base\InvalidValueException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "cd_question".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $title
 * @property integer $view_count
 * @property integer $favorite_count
 * @property integer $answer_count
 * @property integer $vote_up
 * @property integer $vote_down
 * @property integer $answer_reputation
 * @property integer $open_bounty
 * @property integer $open_bounty_end_time
 * @property integer $created_at
 * @property string $created_ip
 * @property integer $updated_at
 * @property string $updated_ip
 * @property integer $locked_at
 * @property integer $locked_user_id
 * @property integer $status
 * @property string $tags_text
 * @property string $content
 *
 * __get property
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $lockedAt
 * @property string $bountyEndingAt
 * @property string $views
 * @property string $summary
 * @property string $url
 * @property string $relativeCreatedAt
 *
 * Relations
 * @property \common\models\User $user
 * @property \common\models\User $lockedUser
 * @property array|QuestionComment[] $comments
 * @property array|Answer[] $answers
 * @property array|Tag[] $tags
 */
class Question extends \yii\db\ActiveRecord
{
    use DateTimeTrait;

    const STATUS_ACTIVE = 10;
    const STATUS_DONE = 20;

    public static function statuses()
    {
        return [self::STATUS_ACTIVE, self::STATUS_DONE];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_QUESTION;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'content'], 'required'],
            [['user_id', 'view_count', 'favorite_count', 'answer_count', 'vote_up', 'vote_down', 'open_bounty', 'open_bounty_end_time', 'answer_reputation', 'created_at', 'updated_at', 'status', 'locked_at', 'locked_user_id'], 'integer'],
            [['title', 'tags_text'], 'string', 'max' => 250],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            ['status', 'in', 'range' => static::statuses()],
            [['status'], 'default', 'value'=>self::STATUS_ACTIVE],
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
            'user_id' => '用户ID',
            'title' => '标题',
            'view_count' => '浏览数',
            'favorite_count' => '收藏数',
            'answer_count' => '回答数',
            'vote_up' => '支持数',
            'vote_down' => '反对数',
            'open_bounty' => '赏金',
            'open_bounty_end_time' => '悬赏结束时间',
            'answer_reputation' => '需要声望',
            'created_at' => '创建时间',
            'created_ip' => '创建IP',
            'updated_at' => '更新时间',
            'updated_ip' => '更新IP',
            'locked_at' => '锁定时间',
            'locked_user_id' => '锁定用户',
            'status' => '状态',
            'tags_text' => '标签',
            'content' => '内容',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields['createdAt'] = [$this, 'getCreatedAt'];
        $fields['updatedAt'] = [$this, 'getUpdatedAt'];
        $fields['lockedAt'] = [$this, 'getLockedAt'];
        $fields['views'] =  [$this, 'getViews'];
        $fields['summary'] =  [$this, 'getSummary'];
        $fields['url'] =  [$this, 'getUrl'];
        $fields['absoluteUrl'] =  [$this, 'getAbsoluteUrl'];
        $fields['relativeCreatedAt'] =  [$this, 'getRelativeCreatedAt'];

        return $fields;
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

    public static function find()
    {
        return new QuestionQuery(get_called_class());
    }


    /******************** __get *********************************/

    public function getViews()
    {
        return formatter()->asSizeNumber((int)$this->view_count, 1);
    }

    public function getTagsLinks($tagname = 'a', $class='label-tag')
    {
        $html = '';
        $tags = explode(',', $this->tags_text);
        foreach ($tags as $tag) {
            $url = Url::toRoute(['question/tagged', 'name'=>$tag]);
            $html .= Html::tag($tagname, $tag, ['class'=>$class, 'href'=>$url]);
        }

        return $html;
    }

    public function getSummary($len = 180)
    {
        $len = (int)$len;
        $text = formatter()->asPlain($this->content);
        return ($len > 0) ? mb_strimwidth($text, 0, $len, '...', app()->charset) : $text;
    }

    /**
     * return model's locked_at text
     * @param null|string $format
     * @return string
     */
    public function getLockedAt($format = null)
    {
        if (empty($format))
            $format = 'Y-m-d H:i';
        return empty($this->locked_at) ? '' : date($format, $this->locked_at);
    }

    public function getBountyEndingAt($format = null)
    {
        if (empty($format))
            $format = 'Y-m-d H:i';
        return empty($this->open_bounty_end_time) ? '' : date($format, $this->open_bounty_end_time);
    }

    public function getBountyLeaveTime()
    {
        if ($this->open_bounty > 0 && $this->open_bounty_end_time > REQUEST_TIME) {
            $endTime = new DateTime();
            $endTime->setTimestamp($this->open_bounty_end_time);
            $interval = $endTime->diff(new DateTime());
            $days = $interval->d ? $interval->d . ' 天 ' : '';
            $hours = $interval->h ? $interval->h . ' 小时 ' : '';
            $minutes = $interval->i ? $interval->i . ' 分钟' : '';

            return $days . $hours . $minutes;
        }

        return null;
    }

    public function getRelativeCreatedAt()
    {
        return formatter()->asRelativeTime($this->created_at);
    }

    public function getUrl()
    {
        return Url::toRoute(['question/show', 'id' => $this->id]);
    }

    public function getAbsoluteUrl()
    {
        return Url::toRoute(['question/show', 'id' => $this->id], true);
    }


    /******************** Relational Data ***********************/

    /**
     * Question has_one User via User.id -> user_id
     * @return UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('questions');
    }

    /**
     * Question has_one User via User.id -> locked_user_id
     * @return UserQuery
     */
    public function getLockedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'locked_user_id'])->inverseOf('questions');
    }

    /**
     * Question has_many QuestionComment via QuestionComment.question_id -> id
     * @return QuestionQuery
     */
    public function getComments()
    {
        return $this->hasMany(QuestionComment::className(), ['question_id' => 'id'])->inverseOf('question');
    }

    /**
     * Question has_many Answer via Answer.question_id -> id
     *
     * @return AnswerQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id'])
            ->inverseOf('question');
    }

    /**
     * Question has_many Tag via Tag.id -> question_tag.tag_id and question_tag.question_id -> id
     * @return TagQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable(TBL_QUESTION_TAG, ['question_id' => 'id']);
    }


    /******************** helper methods ***********************/

    public function getSortComments($sort)
    {
        $sorts = [ANSWER_SORT_ACTIVE, ANSWER_SORT_VOTES, ANSWER_SORT_OLDEST];
        if (in_array($sort, $sorts))
            return Url::toRoute(['question/show', 'id'=>$this->id, 'sort'=>$sort, '#'=>'answers']);
        else
            throw new \InvalidArgumentException('$sort 只能取以下值：' . join('|', $sorts));
    }

    public function getViewsClassName($bg = false)
    {
        $count = (int)$this->view_count;
        if ($count > 102400)
            $class = $bg ? 'supernovabg' : 'supernova';
        elseif ($count > 10240)
            $class = $bg ? 'hotbg' : 'hot';
        elseif ($count > 1024)
            $class = 'warm';
        else
            $class = '';

        return $class;
    }

    /******************** event methods ***********************/

    public function afterDelete()
    {
        // delete all answers
        if ($this->answers) {
            foreach ($this->answers as $answer)
                $answer->delete();
        }
    }

}


class QuestionQuery extends ActiveQuery
{
    /**
     * @return QuestionQuery $this
     */
    public function active()
    {
        $this->andWhere(['status' => Question::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @return QuestionQuery $this
     */
    public function done()
    {
        $this->andWhere(['status' => Question::STATUS_DONE]);
        return $this;
    }
}
