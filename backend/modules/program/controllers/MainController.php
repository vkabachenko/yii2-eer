<?php

namespace backend\modules\program\controllers;

use common\models\Program;
use Yii;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;

class MainController extends GridController
{
    public function init() {

        $this->_model = 'common\models\Program';
        $this->_idParentName = 'id_faculty';

    }


    protected function createProvider($query) {

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['code' => SORT_ASC,]
            ],
            'pagination' => false,
        ]);
    }


    protected function getIdFaculty($id, $parent = false) {

        if ($parent)
            return $id;
        else {
            $model = Program::findOne($id);
            return $model->id_faculty;
        }

    }

}
