<?php

namespace common\base;

class Controller extends \yii\web\Controller
{
    public $channel;

    public function getChannelClassName($channel = null)
    {
        return ($channel && $this->channel === $channel) ? 'active' : '';
    }
}