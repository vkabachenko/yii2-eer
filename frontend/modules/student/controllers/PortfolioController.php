<?php

namespace frontend\modules\student\controllers;

use common\helpers\YearHelper;
use common\models\StudentEducation;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class PortfolioController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['viewFaculty'],
                        'matchCallback' => [$this,'checkFaculty']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['updateStudent'],
                        'matchCallback' => function($rule,$action) {
                             return Yii::$app->user->can('updateStudent',
                                ['id_student' => Yii::$app->request->get('id')]);
                            }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['download'],
                        'roles' => ['viewFaculty','updateStudent'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                        $this->goHome();
                    }
            ]
        ];
    }

    public function checkFaculty($rule, $action)
    {
        /* @var $model StudentEducation */
        $id_student = Yii::$app->request->get('id');
        $model = StudentEducation::find()->
                 where([
                'id_student' => $id_student,
                'year' => YearHelper::getYear()
                 ])->one();

        if ($model) {
            return Yii::$app->user->can('viewFaculty',
                   ['id_faculty' => $model->idProgram->id_faculty]);
        }
        else
            return false;
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'download' => 'common\actions\DownloadAction',
        ];
    }

    public function actionIndex($id)
    {
        // $id - model Student

        return $this->render('index',[
            'id' => $id,
        ]);

    }

} 