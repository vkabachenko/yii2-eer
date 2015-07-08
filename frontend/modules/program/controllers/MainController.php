<?php

namespace frontend\modules\program\controllers;

use common\models\Faculty;
use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex($id_faculty)
    {
        $faculty = Faculty::findOne($id_faculty);

        return $this->render('index',[
                        'faculty' => $faculty,
        ]);
    }
}
