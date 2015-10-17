<?php


namespace frontend\modules\student\models;

use common\helpers\YearHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentEducation;

class StudentSearch extends StudentEducation
{
    public $studentName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course'], 'integer'],
            [['group', 'studentName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($id_program, $id_student, $params)
    {
        $query = StudentEducation::find()->
            where([
                'id_program' => $id_program,
                'year' => YearHelper::getYear()]);

        $query->andFilterWhere(['id_student' => $id_student]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $provider->setSort([
            'attributes' => [
                'studentName'=>[
                    'asc' => ['student.name' => SORT_ASC],
                    'desc' => ['student.name' => SORT_DESC],
                    'label'=>'StudentName',
                ],
                'course',
                'group',
            ],
            'defaultOrder' => [
                'course' => SORT_DESC,
                'studentName' => SORT_ASC,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {

            $query->joinWith(['idStudent']);
            return $provider;
        }

        $query->andFilterWhere(['course' => $this->course]);
        $query->andFilterWhere(['like','group',$this->group]);

        $query->joinWith(['idStudent' => function ($q) {
                /* @var $q \yii\db\ActiveQuery */
                $q->andWhere('student.name LIKE "%'. $this->studentName . '%" ');
                        }
                    ]);

        return $provider;

    }
}