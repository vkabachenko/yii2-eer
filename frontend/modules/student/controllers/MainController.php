<?php

namespace frontend\modules\student\controllers;

use common\models\Program;
use Yii;
use frontend\modules\student\models\StudentSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\StudentEducation;
use common\helpers\YearHelper;

class MainController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['viewFaculty','updateStudent'],
                        'matchCallback' => [$this,'checkProgram']
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                        $this->goHome();
                    }
            ]
        ];
    }

    public function checkProgram($rule, $action)
    {
            $id_program = Yii::$app->request->get('id_program');
            $id_faculty = Program::findOne($id_program)->id_faculty;
            if (Yii::$app->user->can('viewFaculty',
                ['id_faculty' =>$id_faculty])) {

                return true;
            }
            else  {
                $id_student = Yii::$app->user->identity->id_student;
                if (!$id_student)
                    return false;
                else {
                    $student = StudentEducation::find()->
                        where([
                            'id_student' => $id_student,
                            'year' => YearHelper::getYear(),
                        ])->one();
                    if (!$student) {
                        return false;
                    }
                    else {
                        return $student->id_program == $id_program;
                    }
                }
            }
    }


    public function actionIndex($id_program)
    {

        $id_student = Yii::$app->user->identity->id_student;
        $program = Program::findOne($id_program);
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search($id_program, $id_student, Yii::$app->request->queryParams);

        return $this->render('index', [
            'program' => $program,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
