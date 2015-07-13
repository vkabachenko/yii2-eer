<?php

namespace frontend\modules\program\helpers;

use common\models\Program;
use common\models\ProgramFile;
use common\models\ProgramHeader;
use yii\base\Object;
use yii\helpers\Html;
use yii\helpers\Url;
use common\traits\AttributeTrait;

// sets items array for Accordion widget from the model Program
class AccordionContent extends Object
{
    use AttributeTrait;
    /* @var $model Program */
    private $model;
    private $defaultAttributes = ['code','name'];
    private $disabledAttributes = ['id','id_faculty'];


    private function concatAttributes($attributes, $isLabel=false, $betweenAttr = " " )
    {
        $labels = $this->model->attributeLabels();
        $content = '';
        foreach($attributes as $attribute) {
            if ($this->model->$attribute !== null) {
              $label = $isLabel ? Html::tag('span',$labels[$attribute],
                                ['class' => 'accordionContent'])
                                : '';
              $content .= $label.
                       $this->attributeValue($this->model, $attribute).
                       $betweenAttr;
            }
        }
        return $content;
    }

    // create Disciplines link

    private function disciplinesLink()
    {
        /* @var $header ProgramHeader */
        $attributes = $this->defaultAttributes;
        $additiveHeaders = $this->model->programHeaders;
        foreach($additiveHeaders as $header) {
            $attributes[] = $header->field_shown;
        }

        return Html::a($this->concatAttributes($attributes),
                    Url::to(['/disciplines','id_program' => $this->model->id,]));
    }

    // program description
    private function programContent()
    {

        $attributes = array_diff($this->model->attributes(),
                        $this->defaultAttributes, $this->disabledAttributes);
        $content = $this->concatAttributes($attributes, true, '<br/>');
        $content .= $this->modelFiles();

        return $content;
    }

    // link to files related to model
    private function modelFiles()
    {
        if (ProgramFile::find()->where(['id_program' => $this->model->id])->exists()) {
            return Html::a('Документы',
                        ['/file/program','id' => $this->model->id],
                        ['class' => 'linkedFiles']);
        }
        else {
            return '';
        }
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