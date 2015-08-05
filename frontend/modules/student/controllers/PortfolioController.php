<?php

namespace frontend\modules\student\controllers;


use yii\web\Controller;

class PortfolioController extends Controller{


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'download' => 'common\actions\DownloadAction',
        ];
    }

    public function actionIndex($id)
    {
        // $id - model Student

        return $this->render('index',[
            'id' => $id,
        ]);

    }

} 