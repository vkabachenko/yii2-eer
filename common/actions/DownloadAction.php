<?php

namespace common\actions;

use Yii;
use common\models\File;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use common\helpers\YearHelper;
use common\models\StudentEducation;


class DownloadAction extends Action
{
    public function run($id, $modelFile = '\common\models\File') {
        /* @var $model File */
        $model = new $modelFile;
        $model = $model->findOne($id);
        $path = Yii::getAlias('@frontend/web/files').'/'.$model->filename;

        if ($this->checkFileAccess($model) && file_exists($path)) {
            return Yii::$app->response->sendFile($path, $model->document);
        }
        else {
            throw new NotFoundHttpException('The requested file does not exist.');
        }
    }

    // Доступ на скачивание файла
    // $ model - file или student_portfolio

    private function checkFileAccess($model) {
        /* @var $model \yii\db\ActiveRecord */
        if (!$model)
            return false;
        if ($model->tableName() == 'student_portfolio')
            return $this-> checkPortfolioAccess($model);

        // Если model - file, то скачивать можно либо файлы в свободном доступе
        // либо тем, у которых есть доступ к соответствующей учебной программе
        /* @var $model File */
        if ($model->free_access)
            return true;
        elseif (Yii::$app->user->isGuest)
            return false;
        else
        {
            $id_program = $this->findProgram($model->id);
            return Yii::$app->user->can('viewProgramFiles',['id_program' => $id_program]);
        }
    }

    // $id - id файла
    // этот id может находиться в таблицах: program_file, discipline_file, student_result_file
    // Возврат: id_program, исходя из этих таблиц
    // или null, если этого файла в таблицах нет

    private function findProgram($id_file) {

        /* @var $model \yii\db\ActiveRecord */
        $_models = ['ProgramFile', 'DisciplineFile', 'StudentResultFile'];
        foreach ($_models as $_model) {
            $_model = '\\common\\models\\'.$_model;
            $model = new $_model;
            $model = $model->find()->where(['id_file' => $id_file])->one();
            if ($model) break;
        }

        if (!$model) return null;

        $table = $model->tableName();

        switch ($table) {
            case 'program_file':
                return $model->id_program;
                break;
            case 'discipline_file':
                return $model->idDisciplineName->id_program_main;
                break;
            case 'student_result_file':
                return $model->idStudentResult->idStudentEducation->id_program;
                break;
            default:
                return null;
        }
    }

    // доступ на скачивание файла портфолио

    private function checkPortfolioAccess($model) {

        $id_student = $model->id_student;

        if (!Yii::$app->user->can('updateStudent',['id_student' => $id_student])) {
            $student = StudentEducation::find()->
                where([
                    'id_student' => $id_student,
                    'year' => YearHelper::getYear()
                ])->one();

            if ($student) {
                return Yii::$app->user->can('viewFaculty',
                    ['id_faculty' => $student->idProgram->id_faculty]);
            }
            else
                return false;
        }
        else
            return true;
    }

} 