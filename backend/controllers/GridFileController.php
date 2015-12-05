<?php

// предок для всех контроллеров, использующих GridFileView
// самостоятельно не используется!

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

abstract class GridFileController extends GridController
{

    abstract protected function createQuery($idParent);
    abstract protected function linkParent($idParent, $model);

    public function init() {

        $this->_model = 'common\models\File';

    }

    public function actionIndex($idParent = null)
    {
        if ($idParent == null) {
            throw new NotFoundHttpException('Нет исходной записи для размещения файлов.');
        }

        $query = $this->createQuery($idParent);
        $provider = $this->createProvider($query);

        return $this->render('index', [
            'provider' => $provider,
            'idParent' => $idParent,
        ]);
    }


    /**
     * Creates a new model.
     * @return mixed
     */
    public function actionCreate($idParent = null)
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->_model;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->linkParent($idParent, $model);
            if (Yii::$app->request->post('submitButton') !== null) {
                return 'Item is succesfully created.'; // alert message
            }
        }
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    protected function createProvider($query) {

    return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC,]
            ],
            'pagination' => false,
        ]);
    }



}
