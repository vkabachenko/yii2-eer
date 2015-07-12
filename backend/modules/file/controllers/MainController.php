<?php


namespace backend\modules\file\controllers;

use Yii;
use yii\web\Controller;


class MainController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'download' => 'common\actions\DownloadAction',
        ];
    }

} 