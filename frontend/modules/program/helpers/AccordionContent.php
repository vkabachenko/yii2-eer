<?php

namespace frontend\modules\program\helpers;

use common\helpers\YearHelper;
use common\models\StudentEducation;
use Yii;
use common\models\Program;
use common\models\ProgramFile;
use yii\base\Object;
use yii\helpers\Html;
use yii\helpers\Url;

// sets items array for Accordion widget from the model Program
class AccordionContent extends Object
{

    /* @var $model Program */
    private $model;

    // create Disciplines link

	private function disciplinesLink()
	{
		return Html::a('Дисциплины',
			['/discipline/main/index','id_program' => $this->model->id],
			['class' => '']
		);
	}
	
    // program description
    private function programContent()
    {

        return $this->model->fullContent.Html::Tag('div', 
		$this->linkFiles().$this->linkStudents().$this->disciplinesLink(),
		['class' => 'program_links']
		);

    }

    // link to files related to model
    private function linkFiles()
    {
        if (ProgramFile::find()->where(['id_program' => $this->model->id])->exists()) {
            return Html::a('Документы',
                        ['/file/main/program','id' => $this->model->id],
                        ['class' => 'linkedFiles']);
        }
        else {
            return '';
        }
    }

    // link to students related to model
    private function linkStudents()
    {
            if ($this->allowed()) {
                return Html::a('Студенты',
                   ['/student/main/index','id_program' => $this->model->id],
                   ['class' => 'programLinks']);
            }
            else {
                return '';
            }
    }

    // check if user allowed to view students
    private function allowed()
    {

        if (Yii::$app->user->can('viewFaculty',['id_faculty' => $this->model->id_faculty])) {
            return true;
        }
        elseif (Yii::$app->user->can('updateStudent')) {
            $student = StudentEducation::find()->
                       where([
                           'id_student' => Yii::$app->user->identity->id_student,
                           'year' => YearHelper::getYear(),
                       ])->one();
            if (!$student) {
                return false;
            }
            else {
                return $student->id_program == $this->model->id;
            }
        }
        else
            return false;

    }

    // get list of programs

    public function items($id_faculty) {

        $items = [];

        $models = Program::find()->where(['id_faculty' => $id_faculty])->orderBy('code')->all();

        foreach($models as $model) {
            $this->model = $model;
            $items[] = [
                'header' => $this->model->fullName,
                'content' => $this->programContent(),
            ];
        }
        return $items;
    }

}