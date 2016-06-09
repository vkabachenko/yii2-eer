<?php
// Widget for jumbotrone in frontend's layout

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class JumboWidget extends Widget {

    public function run()
    {
        $dimensions = '30';
        $model = isset($this->view->params['model']) ?
            $this->view->params['model'] : null;
        $header = isset($this->view->params['header']) ?
            $this->view->params['header'] : $this->view->title;
        /* @var $faculty \common\models\Faculty */
        $faculty = $this->getFaculty($model);
        $facultyLink = '';
        if ($faculty && $faculty->image) {
            $facultyLink = Html::a(Html::img('/files/'.$faculty->filename,[
                    'alt' => $faculty->name,
                    'width' => $dimensions,
					'class' => 'faculty_emblem'
                ]),
                ['/program/main/index','id_faculty' => $faculty->id]);
        }

        return Html::tag('h2',$facultyLink.$header);
    }

    private function getFaculty($model) {

        if ($model instanceof \common\models\Faculty) {
            return $model;
        } elseif ($model instanceof \common\models\Program) {
            return $model->idFaculty;
        } elseif ($model instanceof \common\models\DisciplineSemester) {
            return $model->idDiscipline->idProgram->idFaculty;
        } elseif ($model instanceof \common\models\StudentEducation) {
            return $model->idProgram->idFaculty;
        } elseif ($model instanceof \common\models\StudentResult) {
            return $model->idStudentEducation->idProgram->idFaculty;
        }

        else {
            return null;
        }



    }



} 