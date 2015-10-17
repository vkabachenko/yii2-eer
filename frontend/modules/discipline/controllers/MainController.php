<?php

namespace frontend\modules\discipline\controllers;

use common\models\Program;
use Yii;
use frontend\modules\discipline\models\DisciplineSearch;
use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex($id_program)
    {
        $program = Program::findOne($id_program);
        $searchModel = new DisciplineSearch();
        $dataProvider = $searchModel->search($id_program, Yii::$app->request->queryParams);

        Yii::$app->session->set('disciplinePage',Yii::$app->request->get('page'));

        return $this->render('index', [
            'program' => $program,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
}
