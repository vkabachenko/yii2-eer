<?php

namespace frontend\modules\student\controllers;



use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\StudentEducation;
use common\models\StudentResult;
use common\models\DisciplineSemester;
use yii\data\ActiveDataProvider;
use common\helpers\ResultHelper;
use yii\filters\AccessControl;

class ResultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','discipline','view-student','view-discipline'],
                        'roles' => ['viewFaculty'],
                        'matchCallback' => [$this,'checkFaculty']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view-student'],
                        'roles' => ['updateStudent'],
                        'matchCallback' => [$this,'checkStudent']
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                        $this->goHome();
                    }
            ]
        ];
    }

    public function checkFaculty($rule, $action) {

        $id = Yii::$app->request->get('id');

        switch ($action->id) {
            case 'index':
                /* @var $model StudentEducation */
                $model = StudentEducation::findOne($id);
                $id_faculty = $model->idProgram->id_faculty;
                break;
            case 'discipline':
                /* @var $model DisciplineSemester */
                $model = DisciplineSemester::findOne($id);
                $id_faculty = $model->idDiscipline->idProgram->id_faculty;
                break;
            case 'view-student':
            case 'view_discipline':
                /* @var $model StudentResult */
                $model = StudentResult::findOne($id);
                $id_faculty = $model->idDisciplineSemester->idDiscipline->idProgram->id_faculty;
                break;
            default:
                $id_faculty = null;
        }

        return Yii::$app->user->can('viewFaculty',['id_faculty' => $id_faculty]);
    }


    public function checkStudent($rule, $action) {

        $id = Yii::$app->request->get('id');

        switch ($action->id) {
            case 'index':
                /* @var $model StudentEducation */
                $model = StudentEducation::findOne($id);
                $id_student = $model->id_student;
                break;
            case 'view-student':
                /* @var $model StudentResult */
                $model = StudentResult::findOne($id);
                $id_student = $model->idStudentEducation->id_student;
                break;
            default:
                $id_student = null;
        }

        return Yii::$app->user->can('updateStudent',['id_student' => $id_student]);
    }


    public function actionIndex($id)
    {
        // $id - StudentEducation
             /* @var $student StudentEducation */
             $student = StudentEducation::findOne($id);

             $provider = new ActiveDataProvider([
                 'query' => ResultHelper::StudentResults($id),
                 'pagination' => [
                     'pageSize' => 10,
                 ],
             ]);

             Yii::$app->session->set('studentResultPage',Yii::$app->request->get('page'));

             return $this->render('student', [
                 'provider' => $provider,
                 'student' => $student,
             ]);
    }

    public function actionDiscipline($id, $id_discipline_name = null)
    {
       // $id - DisciplineSemester

        $disciplineSemester = DisciplineSemester::findOne($id);

        $provider = new ActiveDataProvider([
            'query' => ResultHelper::DisciplineResults($id, $id_discipline_name),
            'pagination' => [
                 'pageSize' => 10,
             ],
        ]);
        Yii::$app->session->set('disciplineResultPage',Yii::$app->request->get('page'));

        return $this->render('discipline', [
            'provider' => $provider,
            'disciplineSemester' => $disciplineSemester,
        ]);

    }

    public function actionViewStudent($id) {
    // $id - StudentResult

        $model = StudentResult::findOne($id);
        return $this->render('viewStudent',['model' => $model]);

    }

    public function actionViewDiscipline($id) {
        // $id - StudentResult

        $model = StudentResult::findOne($id);
        return $this->render('viewDiscipline',['model' => $model]);

    }
}
