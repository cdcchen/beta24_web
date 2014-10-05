<?php

namespace frontend\models;

use common\models\Question;
use yii\base\Model;

class QuestionForm extends Model
{
    const TAG_MIN_COUNT = 1;
    const TAG_MAX_COUNT = 5;

    public $title;
    public $content;
    public $tags_text;

    public function rules()
    {
        return [
            [['title', 'content', 'tags_text'], 'required'],
            ['title', 'string', 'max'=>250],
            ['content', 'string', 'max'=>65000],
            [['title', 'tags_text'], 'filter', 'filter' => 'trim'],
            [['tags_text'], 'validateTagsText'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'content' => '内容',
            'tags_text' => '标签',
        ];
    }

    public function validateTagsText($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $tags = $this->parseTagsText();
            if (count($tags) > self::TAG_MAX_COUNT)
                $this->addError($attribute, '最多只能' . self::TAG_MAX_COUNT . '个标签');
        }
    }

    private function parseTagsText()
    {
        $tags = explode(',', $this->tags_text);
        array_walk($tags, 'trim');
        return array_filter($tags);
    }

    public function beforeValidate()
    {
        parent::beforeValidate();

        $userID = user()->getId();
        if ($userID === null) {
            $this->addError('user_id', '您需要先登录');
            return false;
        }
        else
            $this->user_id = $userID;

        return true;
    }

    public function save()
    {
        $question = new Question();
        $question->attributes = $this->attributes;
        $question->status = Question::STATUS_ACTIVE;
        $question->save();
        return $question;
    }
}