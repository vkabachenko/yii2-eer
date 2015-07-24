<?php

namespace frontend\modules\student\controllers;

use common\models\Program;
use Yii;
use frontend\modules\student\models\StudentSearch;
use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex($id_program)
    {
        $program = Program::findOne($id_program);
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search($id_program, Yii::$app->request->queryParams);

        return $this->render('index', [
            'program' => $program,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
