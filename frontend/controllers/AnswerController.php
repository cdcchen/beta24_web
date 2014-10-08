<?php

namespace frontend\controllers;

use common\models\Answer;
use frontend\base\Controller;
use frontend\models\AnswerForm;

class AnswerController extends Controller
{
    public function init()
    {
        parent::init();

        $this->channel = CHANNEL_QUESTION;
    }


    public function actionCreateAnswer()
    {
        $answerForm = new AnswerForm();
        if (request()->getIsPost() && $answerForm->load(request()->post()) && $answerForm->validate()) {
            if ($answer = $answerForm->save()) {
                $this->redirect($answer->getUrl());
            }
            else
                var_dump($answer->getErrors());
        }
        else
            var_dump($answerForm->getErrors());
    }

    public function actionVoteUp()
    {
        $id = (int)request()->post('id');
        static::ajaxVote($id, 'vote_up');
    }

    public function actionVoteDown()
    {
        $id = (int)request()->post('id');
        static::ajaxVote($id, 'vote_down');
    }

    private static function ajaxVote($id, $column, $step = 1)
    {
        $id = (int)$id;
        $answer = Answer::find()
            ->select(['id', 'vote_up', 'vote_down'])
            ->where('id = :answer_id', [':answer_id' => $id])
            ->one();
        $answer->$column += (int)$step;
        $result = $answer->save(true, ['vote_up']);

        $data['errno'] = $result ? YES : NO;
        $data['vote'] = $result ? $answer->$column : 0;

        echo json_encode($data);
        exit(0);
    }

}