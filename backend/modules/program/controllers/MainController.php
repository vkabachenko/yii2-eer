<?php

namespace backend\modules\program\controllers;

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
}
