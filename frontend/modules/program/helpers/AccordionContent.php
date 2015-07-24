<?php

namespace frontend\modules\program\helpers;

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

        return Html::a($this->model->fullName,
                    Url::to(['/discipline','id_program' => $this->model->id,]));
    }

    // program description
    private function programContent()
    {

        return $this->model->fullContent.$this->linkFiles().$this->linkStudents();

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
            return Html::a('Студенты',
                ['/student','id_program' => $this->model->id],
                ['class' => 'programLinks']);
    }

    public function items($id_faculty) {

        $items = [];

        $models = Program::find()->where(['id_faculty' => $id_faculty])->orderBy('code')->all();

        foreach($models as $model) {
            $this->model = $model;
            $items[] = [
                'header' => $this->disciplinesLink(),
                'content' => $this->programContent(),
            ];
        }
        return $items;
    }

}