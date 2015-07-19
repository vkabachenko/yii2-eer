<?php

namespace common\helpers;

use yii\base\Object;
use Yii;
use yii\web\Cookie;


class YearHelper extends Object
{

    public static function getYear()
    {

        $year = Yii::$app->getRequest()->getCookies()->getValue('year');
        if (!$year) {
            $year = date('Y');
            self::setYear($year);
        }

        return $year;

    }

    public static function setYear($year)
    {
        $cookie = new Cookie([
            'name' => 'year',
            'value' => "$year",
            'expire' => time() + 86400 * 30,
        ]);
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }

    public static function getEducationYear() {

        $year = self::getYear();
        $nextYear = substr($year + 1,2);
        return "$year/$nextYear";

    }

} 