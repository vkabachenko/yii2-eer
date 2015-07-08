<?php

// предок для всех контроллеров, использующих GridView
// самостоятельно не используется!

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GridController extends Controller
{
    protected $_model; // Какая модель используется в контроллере
    protected $_idParentName; // имя id родительской таблицы



    public function actionIndex($idParent = null)
    {

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->_model;
        $query = $model->find();

        if ($idParent) {
            $query->andWhere([$this->_idParentName => $idParent]);
        }

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
        if ($idParent) {
            $idParentName = $this->_idParentName;
            $model->$idParentName = $idParent;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'Item is succesfully created.'; // alert message
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing  model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        /* @var $model \yii\db\ActiveRecord */

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return '';
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing model.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post('approve')) {
            $this->findModel($id)->delete();
            return '';
        }

        return $this->renderAjax('delete', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the model based on its primary key value or create a new model
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->_model;
        if (($model = $model->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function createProvider($query) {

        return null;

    }

}
