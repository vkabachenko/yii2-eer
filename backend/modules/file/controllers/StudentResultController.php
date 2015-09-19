<?php

namespace backend\modules\file\controllers;

use common\models\StudentResult;
use common\models\StudentResultFile;
use Yii;
use backend\controllers\GridFileController;
use common\models\File;

class StudentResultController extends GridFileController
{

    protected function createQuery($idParent) {

        return File::find()->join('INNER JOIN','student_result_file',
            'student_result_file.id_file = file.id')
            ->where(['student_result_file.id_student_result' => $idParent]);

    }

    protected function linkParent($idParent, $model) {

    // $model - File
    // $idParent - id StudentResult
    /* @var $studentResult StudentResult */

          $studentResult = StudentResult::findOne($idParent);

// для работы link в модели StudentResult должен быть определен метод getFiles
          $studentResult->link('files',$model);

    }

    protected function getIdFaculty($id, $parent = false) {

        if ($parent) {
            if ($id == null) return null;
            $model = StudentResult::findOne($id);
            return $model->idStudentEducation->idProgram->id_faculty;
        }
        else {
            $model = StudentResultFile::find()->where(['id_file' => $id])->one();
            return $this->getIdFaculty($model->id_student_result,true);
        }
    }


}
