<?php

namespace backend\modules\student\controllers;

use common\helpers\YearHelper;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use common\models\StudentEducation;
use common\models\StudentResult;
use yii\data\ActiveDataProvider;
use common\helpers\ResultHelper;
use yii\web\Controller;
use yii\filters\AccessControl;
use bupy7\ajaxfilter\AjaxFilter;


class ResultController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','update','delete'],
                        'roles' => ['updateFaculty'],
                        'matchCallback' => [$this,'CheckFaculty']
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                        $this->redirect(['/site/login']);
                    }
            ],
            'ajax' => [
                'class' => AjaxFilter::className(),
                'actions' => ['update','delete'],
            ],
        ];

    }

    public function CheckFaculty($rule, $action) {

        /* @var $model StudentEducation */
        switch ($action->id) {
          case 'index': {
              $model = StudentEducation::find()->where([
                  'id_student' =>Yii::$app->request->get('id'),
                  'year' => YearHelper::getYear(),
                      ])->one();
              $id_faculty = $model ? $model->idProgram->id_faculty: null;
              break;
            }
            case 'update': {
              $model = StudentEducation::findOne(Yii::$app->request->get('id_student'));
              $id_faculty = $model->idProgram->id_faculty;
              break;
            }
            case 'delete': {
              $id = Yii::$app->request->get('id');
              if ($id) {
                  /* @var $result StudentResult */
                  $result = StudentResult::findOne($id);
                  $model = StudentEducation::findOne($result->id_student_education);
                  $id_faculty = $model->idProgram->id_faculty;
              }
              else
                  $id_faculty = null;
              break;
            }
            default: $id_faculty = null;
        }

        return Yii::$app->user->can('updateFaculty',
                     ['id_faculty' => $id_faculty]);

    }

    public function actionIndex($id) {
        // $id - in Student

        /* @var $student StudentEducation */
        $student = StudentEducation::find()->where([
                    'id_student' => $id,
                    'year' => YearHelper::getYear()
        ])->one();

        if (!$student) {
            $this->redirect($this->goHome());
        }

        $provider = new ActiveDataProvider([
            'query' => ResultHelper::StudentResults($student->id),
            'pagination' => false,
        ]);

        return $this->render('index', [
            'provider' => $provider,
            'student' => $student,
            ]);
    }

    public function actionUpdate($id_student, $id_semester, $id_result = null)
    {

        if ($id_result) {
            $results = ResultHelper::examList($id_result);
        }
        else {
            $results = ResultHelper::newExamList($id_student, $id_semester);
        }

            if (Model::loadMultiple($results,Yii::$app->request->post()) &&
                Model::validateMultiple($results)) {

                foreach ($results as $result) {
                    if ($result->assesment || $result->rating)
                       $result->save(false);
                    else
                        if ($id_result) $result->delete();
                }
                return '';
            }

            return $this->renderAjax('update', ['results' => $results]);
    }


    public function actionDelete($id = null)
    {
        if ($id == null) {
            $model = null;
        }
        else {
            $model = $this->findModel($id);

            if (Yii::$app->request->post('approve')) {
                $this->findModel($id)->delete();
                return '';
            }
        }

        return $this->renderAjax('delete', [
            'model' => $model,
        ]);
    }



    protected function findModel($id)
    {
        /* @var $model StudentResult */
        $model = new StudentResult();
        if (($model = $model->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

} 
