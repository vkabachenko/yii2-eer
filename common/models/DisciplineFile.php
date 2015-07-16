<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discipline_file".
 *
 * @property integer $id
 * @property integer $id_discipline_name
 * @property integer $id_file
 *
 * @property File $idFile
 * @property DisciplineName $idDisciplineName
 */
class DisciplineFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discipline_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_discipline_name', 'id_file'], 'required'],
            [['id_discipline_name', 'id_file'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_discipline_name' => 'Id Discipline Name',
            'id_file' => 'Id File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFile()
    {
        return $this->hasOne(File::className(), ['id' => 'id_file']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDisciplineName()
    {
        return $this->hasOne(DisciplineName::className(), ['id' => 'id_discipline_name']);
    }
}
