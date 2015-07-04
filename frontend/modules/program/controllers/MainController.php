<?php

namespace frontend\modules\program\controllers;

use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex($id_faculty)
    {
        return $this->render('index');
    }
}
