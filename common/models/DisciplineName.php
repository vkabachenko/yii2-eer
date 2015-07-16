<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discipline_name".
 *
 * @property integer $id
 * @property integer $id_discipline
 * @property integer $id_program_main
 * @property string $suffix
 * @property string $name
 *
 * @property DisciplineFile[] $disciplineFiles
 * @property Discipline $idDiscipline
 */
class DisciplineName extends \yii\db\ActiveRecord
{
    private $id_discipline_cached; // для удаления связанной дисциплины
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discipline_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_discipline', 'name'], 'required'],
            [['id_discipline'], 'integer'],
            [['suffix'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_discipline' => 'Id Discipline',
            'suffix' => 'Суффикс',
            'name' => 'Наименование',
            'disciplineCode' => 'Шифр',
            'disciplineSemesters' => 'Семестры',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineFiles()
    {
        return $this->hasMany(DisciplineFile::className(), ['id_discipline_name' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'id_file'])
            ->via('disciplineFiles');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'id_discipline']);
    }

    /**
     * getter for code
     */
    public function getDisciplineCode()
    {
        $suffix = $this->suffix ? '-'.$this->suffix : '';

        return $this->idDiscipline->code.$suffix;
    }

    /**
     * getter for semesters
     */
    public function getDisciplineSemesters() {

        $id_discipline = $this->idDiscipline->id;
        $semesters = DisciplineSemester::find()->
                where(['id_discipline' => $id_discipline])->
                orderBy('semester')->
                indexBy('semester')->
                asArray()->all();
        $semesters = array_keys($semesters);
        return implode(', ',$semesters);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'id_program_main']);
    }

    /**
     * @inheritdoc
     * Сохраняем id связанной дисциплины для послдующего ее удаления
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->id_discipline_cached = $this->id_discipline;
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @inheritdoc
     * Удаляем связанную дисциплину, если не осталось для нее записи с именем
     */
    public function afterDelete()
    {
        if (!static::find()->
            where(['id_discipline' => $this->id_discipline_cached])->
            exists()) {
                Discipline::findOne($this->id_discipline_cached)->delete();
        }
    }

}
