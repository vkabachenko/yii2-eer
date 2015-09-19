<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;
use common\models\User;


class MainController extends GridController
{

    public function init() {

        $this->_model = 'common\models\User';
        $this->_idParentName = 'id_faculty';

    }

    protected function createProvider($query) {

        /* @var $query \yii\db\ActiveQuery */
        $query->andWhere(['<>','role',User::ROLE_STUDENT])->
                andWhere(['<>','role',User::ROLE_ADMIN]);

        /* @var $provider ActiveDataProvider */
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $provider->setSort([
            'attributes' => [
                'username',
                'email',
                'facultyName'=>[
                    'asc' => ['faculty.name' => SORT_ASC],
                    'desc' => ['faculty.name' => SORT_DESC],
                    'label'=>'FacultyName',
                ],
                'role'
            ],
            'defaultOrder' => ['facultyName'=>SORT_ASC,'username' => SORT_ASC,]
        ]);

        $query->joinWith(['idFaculty']);

        return $provider;

    }

    protected function getIdFaculty($id, $parent = false) {

        if ($parent)
            return $id;
        else {
            $model = User::findOne($id);
            return $model->id_faculty;
        }


    }

}
