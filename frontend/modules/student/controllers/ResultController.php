<?php

namespace frontend\modules\student\controllers;


use common\models\DisciplineSemester;
use common\models\StudentResult;
use Yii;
use yii\web\Controller;
use common\models\StudentEducation;
use yii\data\ActiveDataProvider;
use common\helpers\ResultHelper;

class ResultController extends Controller
{
    public function actionIndex($id)
    {
        // $id - StudentResult
             /* @var $student StudentEducation */
             $student = StudentEducation::findOne($id);

             $provider = new ActiveDataProvider([
                 'query' => ResultHelper::StudentResults($id),
                 'pagination' => false,
             ]);

             return $this->render('student', [
                 'provider' => $provider,
                 'student' => $student,
             ]);
    }

    public function actionDiscipline($id)
    {
       // $id - DisciplineSemester

        $disciplineSemester = DisciplineSemester::findOne($id);

        $provider = new ActiveDataProvider([
            'query' => ResultHelper::DisciplineResults($id),
            'pagination' => false,
        ]);

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
