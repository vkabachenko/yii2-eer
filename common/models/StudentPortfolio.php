<?php


namespace common\models;

use backend\behaviors\FileBehavior;
use Yii;

/* @property integer    $id_student */
/* @property string    $document */
/* @property string    $filename */

class StudentPortfolio  extends \kartik\tree\models\Tree {

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            FileBehavior::className()
        ]);
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_portfolio';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge($this->ruleFile(),[
            [['name','collapsed','visible',
              'active','removable','removable_all'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge($this->nameFile(),[
            'name' => 'Наименование',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->id_student = Yii::$app->session['id_student'];
            $this->collapsed = 1;
            return true;
        }
        else
            return false;
    }

} 