<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 *
 * @property StudentEducation[] $studentEducations
 * @property StudentPortfolio[] $studentPortfolios
 */
class Student extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','email'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 250],
            [['email'], 'email'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Фамилия Имя Отчество',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentEducations()
    {
        return $this->hasMany(StudentEducation::className(), ['id_student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentPortfolios()
    {
        return $this->hasMany(StudentPortfolio::className(), ['id_student' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
/*
 * Удаляются все записи портфолио.
 * Поскольку модель Tree не поддерживает удаление корневых элементов,
 * для удаления не используется стандартный метод delete модели, а
 * используется DAO.
 */
     if (parent::beforeDelete()) {
 /*
 * Сначала удаляются все файлы, связанные с портфолио, а затем все записи
 */
        $models = $this->studentPortfolios;
        foreach ($models as $model) {
            $model->deleteFile();
        }

        Yii::$app->db->
            createCommand()->
            delete('student_portfolio',['id_student' => $this->id])->
            execute();
         return true;
     }
     else {
         return false;
     }
  }
}
