<?php

namespace frontend\modules\file\controllers;


use common\models\Program;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class ProgramController extends Controller
{
    /**
     * возвращает список файлов, связанный с данной образовательной программой
     * @param $id - id Program
     */
    public function actionIndex($id) {

        $files = Program::findOne($id)->getFiles()->all();
        $provider = new ArrayDataProvider([
            'allModels' => $files,
            'sort' => [
                'attributes' => ['title'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->renderPartial('list',['provider' => $provider]);

    }

} 