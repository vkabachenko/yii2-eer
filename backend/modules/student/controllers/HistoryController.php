<?php

namespace backend\modules\student\controllers;

use common\helpers\YearHelper;
use common\models\Program;
use Yii;

use backend\controllers\GridController;
use yii\data\ActiveDataProvider;
use common\models\Student;
use common\models\StudentEducation;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class HistoryController  extends GridController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'] = array_merge([
                [
                    'allow' => true,
                    'actions' => ['program'],
                    'roles' => ['updateFaculty'],
                ],
            ],
            $behaviors['access']['rules'] );

        return $behaviors;
    }

    public function init() {

        $this->_model = 'common\models\StudentEducation';
        $this->_idParentName = 'id_student';

    }

    protected function createProvider($query) {

        /* @var $query \yii\db\ActiveQuery */
        /* @var $provider ActiveDataProvider */
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $provider->setSort([
            'attributes' => [
                'year',
                'course',
                'programName'=>[
                    'asc' => ['program.name' => SORT_ASC],
                    'desc' => ['program.name' => SORT_DESC],
                    'label'=>'ProgramName',
                ],
            ],
            'defaultOrder' => ['year'=>SORT_ASC,]
        ]);

        $query->joinWith(['idProgram']);

        return $provider;

    }

    public function actionProgram($id_faculty)
    {

        /* @var $model \common\models\Program */
        Yii::$app->response->format = Response::FORMAT_JSON;

        $programs = [];
        $models = Program::find()->where(['id_faculty' => $id_faculty])->all();
        foreach($models as $model) {
            $programs[] = $model->toArray(['id'],['fullName']);
        }
        ArrayHelper::multisort($programs,'fullName');

        return $programs;

    }

    protected function getIdFaculty($id, $parent = false) {

        if ($parent) {
            $model = StudentEducation::find()->where([
                'id_student' => $id,
                'year' => YearHelper::getYear()
            ])->one();

            return $model->idProgram->id_faculty;
        }
        else {
            $model = StudentEducation::findOne($id);
            return $model->idProgram->id_faculty;
        }
    }



}
