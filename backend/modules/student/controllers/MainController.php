<?php

namespace backend\modules\student\controllers;

use common\helpers\YearHelper;
use Yii;

use backend\controllers\GridController;
use yii\data\ActiveDataProvider;
use common\models\Student;
use common\models\StudentEducation;

class MainController  extends GridController
{

    public function init() {

        $this->_model = 'common\models\StudentEducation';
        $this->_idParentName = 'id_program';

    }

    protected function createProvider($query) {

        /* @var $query \yii\db\ActiveQuery */
        $year = YearHelper::getYear();
        $query->andWhere(['year' => $year]);

        /* @var $provider ActiveDataProvider */
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
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

}
