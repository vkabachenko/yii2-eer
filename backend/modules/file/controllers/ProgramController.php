<?php

namespace backend\modules\file\controllers;

use common\models\Program;
use Yii;
use backend\controllers\GridFileController;
use common\models\File;

class ProgramController extends GridFileController
{
    public function init() {

        parent::init();
        $this->_idParentName = 'id_program';

    }


    protected function createQuery($idParent) {

        return File::find()->join('INNER JOIN','program_file',
            'program_file.id_file = file.id')
            ->where(['program_file.id_program' => $idParent]);

    }

    protected function linkParent($idParent, $model) {

    // $model - File
    // $idParent - id Program
    /* @var $program Program */

          $program = Program::findOne($idParent);

// для работы link в модели Program должен быть определен метод getFiles
          $program->link('files',$model);

    }



}
