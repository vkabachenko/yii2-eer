<?php

namespace backend\modules\discipline\controllers;

use common\models\Discipline;
use common\models\DisciplineSemester;
use Yii;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;

class SemesterController extends GridController
{
    public function init() {

        $this->_model = 'common\models\DisciplineSemester';
        $this->_idParentName = 'id_discipline';

    }


    protected function createProvider($query) {

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['semester' => SORT_ASC,]
            ],
            'pagination' => false,
        ]);

    }


    protected function getIdFaculty($id, $parent = false) {

        if ($parent) {
            $model = Discipline::findOne($id);
            return $model->idProgram->id_faculty;
        }
        else {
            $model = DisciplineSemester::findOne($id);
            return $model->idDiscipline->idProgram->id_faculty;
        }
    }

}
