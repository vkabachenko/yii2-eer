<?php

// предок для всех контроллеров, использующих GridView

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use bupy7\ajaxfilter\AjaxFilter;

abstract class GridController extends Controller
{
    protected $_model; // Какая модель используется в контроллере
    protected $_idParentName; // имя id родительской таблицы
    protected $_scenarioCreate; // сценарии при добавлении
    protected $_scenarioUpdate; // и редактировании
    protected $_pageName; // название сессионной переменной, сохраняющей позициию текущей страницы в гриде

    /**
     * @inheritdoc
     */
    /* Массив behaviors модифицирован в контроллерах /discipline/MainController

    При необходимости изменения обязательно проверить!!!
    */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','create'],
                        'roles' => ['updateFaculty'],
                        'matchCallback' => function ($rule, $action) {
                           return Yii::$app->user->can('updateFaculty',
                             ['id_faculty' =>
                               $this->getIdFaculty(Yii::$app->request->
                                   get('idParent'),true)]);
                            }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update','delete'],
                        'roles' => ['updateFaculty'],
                        'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->can('updateFaculty',
                                    ['id_faculty' =>
                                        $this->getIdFaculty(Yii::$app->request->
                                            get('id'))]);
                            }
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(['/site/login']);
                }
            ],
            'ajax' => [
                'class' => AjaxFilter::className(),
                'actions' => ['create','update','delete'],
            ],
        ];

    }


    abstract protected function createProvider($query);

    abstract protected function getIdFaculty($id);

    public function actionIndex($idParent = null)
    {

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->_model;
        $query = $model->find();

        if ($idParent) {
            $query->andWhere([$this->_idParentName => $idParent]);
        }

        $provider = $this->createProvider($query);

        if ($this->_pageName) {
            Yii::$app->session->set($this->_pageName,Yii::$app->request->get('page'));
        }

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

        if ($this->_scenarioCreate) {
            $model->scenario = $this->_scenarioCreate;
        }

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

        if ($this->_scenarioUpdate) {
            $model->scenario = $this->_scenarioUpdate;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save() &&
            Yii::$app->request->post('submitButton') !== null) {
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


}
