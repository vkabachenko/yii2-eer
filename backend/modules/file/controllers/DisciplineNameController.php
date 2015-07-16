<?php

namespace backend\modules\file\controllers;

use common\models\DisciplineName;
use Yii;
use backend\controllers\GridFileController;
use common\models\File;

class DisciplineNameController extends GridFileController
{

    protected function createQuery($idParent) {

        return File::find()->join('INNER JOIN','discipline_file',
            'discipline_file.id_file = file.id')
            ->where(['discipline_file.id_discipline_name' => $idParent]);

    }

    protected function linkParent($idParent, $model) {

    // $model - File
    // $idParent - id DisciplineName
    /* @var $disciplineName DisciplineName */

          $disciplineName = DisciplineName::findOne($idParent);

// для работы link в модели Program должен быть определен метод getFiles
          $disciplineName->link('files',$model);

    }



}
