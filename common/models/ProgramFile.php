<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "program_file".
 *
 * @property integer $id
 * @property integer $id_program
 * @property integer $id_file
 *
 * @property Program $idProgram
 * @property File $idFile
 */
class ProgramFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'program_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_program', 'id_file'], 'required'],
            [['id_program', 'id_file'], 'integer']
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
            'id_file' => 'Id File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'id_program']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFile()
    {
        return $this->hasOne(File::className(), ['id' => 'id_file']);
    }
}
