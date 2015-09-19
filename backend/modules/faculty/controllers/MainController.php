<?php
namespace backend\modules\faculty\controllers;

use common\models\User;
use Yii;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;


class MainController extends GridController
{

    public function init() {
        $this->_model = 'common\models\Faculty';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'] = array_merge([
            [
                'allow' => true,
                'actions' => ['create','delete'],
                'roles' => ['createDeleteFaculty'],
            ],
            [
                'allow' => false,
                'actions' => ['create','delete'],
                'roles' => ['updateFaculty'],
            ],

        ],
            $behaviors['access']['rules'] );

        return $behaviors;
    }

    protected function createProvider($query) {

        /* @var $query \yii\db\ActiveQuery */
        if (Yii::$app->user->identity->role == User::ROLE_LOCAL_ADMIN) {
            $query->andWhere(['id' => Yii::$app->user->identity->id_faculty]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC,]
            ],
            'pagination' => false,
        ]);
    }


    protected function getIdFaculty($id, $parent = false) {

        if ($parent)
            return null;
        else
            return $id;

    }

}
