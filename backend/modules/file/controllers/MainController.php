<?php


namespace backend\modules\file\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;


class MainController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['download'],
                        'roles' => ['updateFaculty'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                        $this->redirect(['/site/login']);
                    }
            ]
        ];

    }



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