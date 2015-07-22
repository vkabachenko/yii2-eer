<?php

namespace backend\modules\program\controllers;

use Yii;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;

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
}
