<?php

namespace backend\modules\student\controllers;

use common\models\StudentPortfolio;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\helpers\YearHelper;
use common\models\StudentEducation;

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
                        'roles' => ['updateFaculty','updateStudent'],
                        'matchCallback' => [$this,'checkStudent']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['download'],
                        'roles' => ['updateFaculty','updateStudent'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                        $this->redirect(['/site/login']);
                    }
            ]
        ];

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


    public function actionIndex($id) {
        // $id - in Student

        $beginNodeId = StudentPortfolio::find()->
                       where([
                         'id_student' => $id,
                         ])->
                       min('id');
        $beginNodeId = $beginNodeId == null ? 0 : $beginNodeId;

        Yii::$app->session['id_student'] = $id;

        return $this->render('index',[
            'id' => $id,
            'beginNodeId' => $beginNodeId,
        ]);

    }


    public function checkStudent($rule,$action) {

           $id_student = Yii::$app->request->get('id');
           return $this->checkAccess($id_student);

    }

    private function checkAccess($id_student) {

        if (Yii::$app->user->can('updateStudent',
            ['id_student' => $id_student])) {
            return true;
        }
        else {
            /* @var $student StudentEducation */
            $student = StudentEducation::find()->where([
                'id_student' => $id_student,
                'year' => YearHelper::getYear()
            ])->one();
            if (Yii::$app->user->can('updateFaculty',
                ['id_faculty' =>
                    $student->idProgram->id_faculty])) {
                return true;
            }
        }
        return false;
    }

}