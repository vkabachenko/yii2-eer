<?php


namespace frontend\modules\file\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;


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

    public function actionProgram($id)
    {

        return $this->renderFiles('common\models\Program', $id);

    }

    public function actionDiscipline($id)
    {

        return $this->renderFiles('common\models\DisciplineName', $id);

    }

    public function actionResult($id)
    {

        return $this->renderFiles('common\models\StudentResult', $id);

    }

    private function renderFiles($_model, $id)
    {

        /* @var $model \yii\db\ActiveRecord */
        $model = new $_model;
        $files = $model->findOne($id)->getFiles()->all();
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