<?php


namespace backend\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;

// Каскадное удаление дочерних таблиц при удалении родительской таблицы

class CascadeBehavior  extends Behavior {

    public $children = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteChildren',
        ];
    }

    public function deleteChildren($event)
    {
        foreach ($this->children as $child ) {

            $models = $this->owner->{$child};
            foreach ($models as $model) {
                $model->delete();
            }
        }
    }

} 