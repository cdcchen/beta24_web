<?php
namespace frontend\models;

use common\models\Answer;
use yii\base\Model;

class AnswerForm extends Model
{
    public $question_id;
    public $content;

    public function rules()
    {
        return [
            [['question_id', 'content'], 'required'],
            ['content', 'string', 'min' =>10, 'max'=>65000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'question_id' => '问题ID',
            'content' => '内容',
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            $answer = new Answer();
            $answer->attributes = $this->attributes;
            $answer->user_id = user()->id;
            return $answer->save() ? $answer : false;
        }
        else
            return false;
    }
}