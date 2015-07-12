<?php
namespace backend\modules\faculty\controllers;

use Yii;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;

class MainController extends GridController
{
    public function init() {
        $this->_model = 'common\models\Faculty';
    }
    protected function createProvider($query) {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC,]
            ],
            'pagination' => false,
        ]);
    }
}
