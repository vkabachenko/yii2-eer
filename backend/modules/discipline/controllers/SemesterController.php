<?php

namespace backend\modules\discipline\controllers;

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
}
