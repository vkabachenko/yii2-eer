<?php

namespace backend\modules\student\controllers;

use common\helpers\YearHelper;
use common\models\StudentEducation;
use Yii;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;
use common\models\User;


class UserController extends GridController
{

    public function init() {

        $this->_model = 'common\models\User';
        $this->_idParentName = 'id_student';
        $this->_scenarioCreate = 'signup';
    }

    protected function createProvider($query) {

        /* @var $query \yii\db\ActiveQuery */

        /* @var $provider ActiveDataProvider */
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $provider;

    }

    protected function getIdFaculty($id, $parent = false) {

        $year = YearHelper::getYear();
        if ($parent)
            $id_student = $id;
        else {
            $model = User::findOne($id);
            $id_student = $model->id_student;
        }

        $student = StudentEducation::find()->
            where(['year' => $year,'id_student' => $id_student])->
            one();

        return $student->idProgram->id_faculty;

    }

}
