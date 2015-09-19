<?php

namespace backend\modules\program\controllers;

use common\models\ProgramHeader;
use Yii;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;
use common\models\Program;

class NameController extends GridController
{
    public function init() {

        $this->_model = 'common\models\ProgramHeader';
        $this->_idParentName = 'id_program';

    }


    protected function createProvider($query) {

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }


    protected function getIdFaculty($id, $parent = false) {

        if ($parent) {
            $model = Program::findOne($id);
        return $model->id_faculty;
        }
        else {
            $model = ProgramHeader::findOne($id);
            return $model->idProgram->id_faculty;
        }
    }

}
