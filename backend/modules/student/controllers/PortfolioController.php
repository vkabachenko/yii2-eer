<?php

namespace backend\modules\student\controllers;

use common\models\StudentPortfolio;
use Yii;
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


    public function actionIndex($id) {
        // $id - in Student

        $beginNodeId = StudentPortfolio::find()->
                       where([
                         'id_student' => $id,
                         ])->
                       min('id');
        $beginNodeId = $beginNodeId == null ? 0 : $beginNodeId;

        Yii::$app->session['id_student'] = $id;

        return $this->render('index',[
            'id' => $id,
            'beginNodeId' => $beginNodeId,
        ]);

    }



}