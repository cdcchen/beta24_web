<?php
namespace frontend\models;

use common\models\Answer;
use yii\base\Model;

class AnswerForm extends Model
{
    public $question_id;
    public $user_id;
    public $content;

    public function rules()
    {
        return [
            [['question_id', 'content', 'user_id'], 'required'],
            ['content', 'string', 'min' =>10, 'max'=>65000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'question_id' => '问题ID',
            'content' => '内容',
            'user_id' => '用户ID',
        ];
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
        $answer = new Answer();
        $answer->attributes = $this->attributes;
        $answer->save();
        return $answer;
    }
}