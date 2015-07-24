<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "program_header".
 *
 * @property integer $id
 * @property integer $id_program
 * @property string $field_shown
 *
 * @property Program $idProgram
 */
class ProgramHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'program_header';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_program', 'field_shown'], 'required'],
            [['id_program'], 'integer'],
            [['field_shown'], 'string', 'max' => 255],
            [['id_program','field_shown'],'unique','targetAttribute' => ['id_program','field_shown']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_program' => 'Id Program',
            'field_shown' => 'Дополнительное поле в наименовании',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'id_program']);
    }

    public function getFieldShownLabel()
    {
        $program = new Program();
        $labels = $program->attributeLabels();
        return $labels[$this->field_shown];
    }

}
