<?php

namespace common\helpers;

use common\models\DisciplineName;
use yii\base\Object;
use common\models\Discipline;


class DisciplineHelper extends Object
{
    public $id;

    public function getName() {
        /* @var $discipline Discipline */
        /* @var $disciplineName DisciplineName */
        $discipline = Discipline::findOne($this->id);

        if ($discipline == null) {
            return 'Not found';
        }

        if ($discipline->block == Discipline::DISCIPLINE_CHOICE) {
            return 'Дисциплина по выбору';
        }
        else {
            $disciplineName = DisciplineName::findOne(['id_discipline' => $this->id]);
            return $disciplineName ? $disciplineName->name : 'Not found';
        }
    }

} 