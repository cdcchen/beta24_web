<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-9-8
 * Time: 下午1:23
 */

namespace common\base;


class Formatter extends \yii\base\Formatter
{
    public function asSizeNumber($value, $decimals = 0, $uppercase = false)
    {
        $position = 0;

        do {
            if ($value < 1024) {
                break;
            }

            $value = $value / 1024;
            $position++;
        } while ($position < 5);

        $value = round($value, $decimals);
        switch ($position) {
            case 0:
                return $value;
            case 1:
                $value .= $uppercase ? 'K' : 'k'; break;
            case 2:
                $value .= $uppercase ? 'M' : 'm'; break;
            case 3:
                $value .= $uppercase ? 'G' : 'g'; break;
            case 4:
                $value .= $uppercase ? 'T' : 't'; break;
            default:
                $value .= $uppercase ? 'P' : 'p'; break;
        }

        return $value;
    }
} 