<?php

namespace backend\modules\faculty\controllers;

use Yii;
use yii\web\Controller;
use common\models\Faculty;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class MainController extends Controller
{
    public function actionIndex()
    {

        $query = Faculty::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC,]
            ],
            'pagination' => false,
        ]);

        return $this->render('index', [
            'provider' => $provider,
        ]);
    }


    /**
     * Creates a new Faculty model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Faculty();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'Item is succesfully created.'; // alert message
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Faculty model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return '';
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Faculty model.
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
     * Finds the Countries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Faculty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faculty::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
