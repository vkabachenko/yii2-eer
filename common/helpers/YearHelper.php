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

    public static function getEducationYear($year=null) {

        $year = $year ?: self::getYear();
        $nextYear = substr($year + 1,2);
        return "$year-$nextYear";

    }

    public static function getDropDownArray($header='') {

        $items = []; // items in the dropdown list
        $itemsNumber = 5; // number of various years in the dropdown list

        $year = self::getYear();
        $currentYear = date('Y') + 1; // including next year

        $firstYear = $year < $currentYear - $itemsNumber ? $year + $itemsNumber : $currentYear;

        for ($y = $firstYear; $y > $firstYear - $itemsNumber; $y--) {
            $items[] = [
                'label' => self::getEducationYear($y),
                'url' => ['/site/year','to' => $y]
            ];
        }

        // add item for setting the year via modalform
        $items[] = '<li class="divider"></li>';
        $items[] = [
            'label' => 'другой...',
            'url' => ['/site/year'],
            'linkOptions' => ['id' => 'year'],
        ];

        return [
            'label' => ltrim($header.' '.self::getEducationYear()),
            'items' => $items
        ];
    }

} 