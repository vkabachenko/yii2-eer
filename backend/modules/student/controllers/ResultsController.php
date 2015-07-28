<?php

namespace backend\modules\student\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\StudentEducation;
use common\models\StudentResult;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;

class ResultsController extends Controller{

    public function actionIndex($id) {
        // $id - in StudentEducation

        /* @var $student StudentEducation */
        $student = StudentEducation::findOne($id);


        $result = new Query();
        $result->
            select(['student_result.*'])->
            from('student_result')->
            innerJoin('student_education',
                'student_education.id = student_result.id_student_education')->
            where(['student_education.id' => $id]);

        $disciplineSemester = new Query();
        $disciplineSemester->
            select(['discipline_semester.*',
                'student_education.id as id_student'])->
            from('discipline_semester')->
            innerJoin('student_education',
                'discipline_semester.course = student_education.course')->
            where(['student_education.id' => $id]);


        $query = new Query();
        $query->
            select(['discipline.code',
                    'semester.id_student',
                    'semester.semester',
                    'semester.id_discipline',
                    'semester.max_rating',
                    'semester.id as id_semester',
                    'result.assesment',
                    'result.rating',
                    'result.id as id_result',
            ])->
            from(['semester' => $disciplineSemester])->
            innerJoin('discipline','semester.id_discipline = discipline.id' )->
            leftJoin(['result' => $result],
                'semester.id = result.id_discipline_semester')->
            orderBy('discipline.code');

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'provider' => $provider,
            'student' => $student,
            ]);
    }

    public function actionUpdate($id_student, $id_semester, $id_result = null) {

    // $id_semester - id discipline_semester
    // $id_result - id student_result или null ,если результата еще нет
    /* @var $model StudentResult */

        if ($id_result) {
            $model = $this->findModel($id_result);
        }
        else {
            $model = new StudentResult();
            $model->id_student_education = $id_student;
            $model->id_discipline_semester = $id_semester;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return '';
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
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