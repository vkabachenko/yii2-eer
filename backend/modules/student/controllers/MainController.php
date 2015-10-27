<?php

namespace backend\modules\student\controllers;

use common\helpers\YearHelper;
use Yii;

use backend\controllers\GridController;
use yii\data\ActiveDataProvider;
use common\models\Student;
use common\models\StudentEducation;
use common\models\Program;

class MainController  extends GridController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][0]['actions'][] = 'transfer';
        $behaviors['ajax']['actions'][] = 'transfer';

        return $behaviors;
    }

    public function init() {

        $this->_model = 'common\models\StudentEducation';
        $this->_idParentName = 'id_program';
        $this->_pageName = 'studentPage';

    }

    protected function createProvider($query) {

        /* @var $query \yii\db\ActiveQuery */
        $year = YearHelper::getYear();
        $query->andWhere(['year' => $year]);

        /* @var $provider ActiveDataProvider */
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $provider->setSort([
            'attributes' => [
                'studentName'=>[
                    'asc' => ['student.name' => SORT_ASC],
                    'desc' => ['student.name' => SORT_DESC],
                    'label'=>'StudentName',
                ],
                'course',
                'group'
            ],
            'defaultOrder' => ['course'=>SORT_DESC,'studentName' => SORT_ASC,]
        ]);

        $query->joinWith(['idStudent']);

        return $provider;

    }

    /**
     * Новая модель student и связанная с ней новая модель student_education
     * @return mixed
     */
    public function actionCreate($idParent = null)
    {
        /* @var $student Student */
        /* @var $studentEducation StudentEducation */

        $student = new Student();
        $studentEducation = new StudentEducation();

        $studentEducation->id_program = $idParent;
        if ($student->load(Yii::$app->request->post()) && $student->save()) {
            $studentEducation->load(Yii::$app->request->post());
            $studentEducation->id_student = $student->id;
            $studentEducation->year = YearHelper::getYear();
            $studentEducation->save();
            return 'Item is succesfully created.'; // alert message
        } else {
            return $this->renderAjax('update', [
                'student' => $student,
                'studentEducation' => $studentEducation,
            ]);
        }
    }

    /**
     * Перевести всех на следующий курс
     */
    public function actionTransfer($idParent)
    {
        if (Yii::$app->request->post('approve')) {
            /* @var $program Program */
            $program = Program::findOne($idParent);

            $duration = $program->duration;
            $year = YearHelper::getYear();
            $newYear = $year + 1;

            $sql = "insert into student_education (id_student, year, id_program, course)
                    select id_student, $newYear, id_program, course + 1
                    from student_education where id_program = $idParent and year = $year
                    and course < $duration and id_student not in (select id_student from
                    student_education where id_program = $idParent and year = $newYear)";

            Yii::$app->db->createCommand($sql)->execute();
            Yii::$app->session->setFlash('success',
                 "Студенты переведены на следующий курс в $newYear учебном году");
            $this->redirect(['index','idParent' => $idParent]);
        }

        return $this->renderAjax('transfer',['idParent' => $idParent]);
    }

    /**
     * Updates an existing  model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /* @var $student Student */
        /* @var $studentEducation StudentEducation */

        $studentEducation = $this->findModel($id);
        $student = $studentEducation->idStudent;

        if ($studentEducation->load(Yii::$app->request->post()) && $studentEducation->save()) {
            $student->load(Yii::$app->request->post());
            $student->save();
            return '';
        } else {
            return $this->renderAjax('update', [
                'student' => $student,
                'studentEducation' => $studentEducation,
            ]);
        }
    }



    protected function getIdFaculty($id, $parent = false) {

        if ($parent) {
            $model = Program::findOne($id);
            return $model->id_faculty;
        }
        else {
            $model = StudentEducation::findOne($id);
            return $model->idProgram->id_faculty;
        }
    }


}
