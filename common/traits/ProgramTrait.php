<?php
namespace common\traits;

use yii\helpers\Html;

trait ProgramTrait
{
    use AttributeTrait;

    // для составления полного имени программы и полного описания программы
    private $defaultAttributes = ['code','name'];
    private $disabledAttributes = ['id','id_faculty'];

    public function getFullContent()
    {

        $attributes = $this->availableAttributes();
        return $this->concatAttributes($attributes, true);

    }

    public function availableAttributes() {

        return array_diff($this->attributes(),
            $this->defaultAttributes, $this->disabledAttributes);

    }


    private function concatAttributes($attributes, $isLabel=false)
    {
        $labels = $this->attributeLabels();
        $content = '';
        foreach($attributes as $attribute) {
            $value = $this->attributeValue($attribute);
            if ($value) {
                if ($isLabel) {
                    $label = Html::tag('span',$labels[$attribute],
                        ['class' => 'programContent']);
                    $content .= Html::tag('div', $label.
                        Html::tag('span', $value,
                            ['class' => '']),
                        ['class' => '']);
                } else {
                    $content .= $value.' ';
                }
            }
        }
        return $content;
    }

}