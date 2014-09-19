<?php

namespace common\config;

class HtmlPurifierConfig
{
    public static function question()
    {
        return [
            'HTML.Allowed' => 'blockquote,code,del,dd,dl,dt,em,h1,h2,h3,i,kbd,li,ul,ol,p,pre,s,sup,sub,strong,strike,br,hr,a[href|title],img[src|alt|title|width]',
            'HTML.MaxImgLength' => 650,
        ];
    }

    public static function answer()
    {
        return static::question();
    }

}