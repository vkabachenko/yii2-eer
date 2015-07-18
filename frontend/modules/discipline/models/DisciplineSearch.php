<?php


namespace frontend\modules\discipline\models;

use common\models\DisciplineSemester;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DisciplineName;

class DisciplineSearch extends DisciplineName
{
    public $disciplineCode;
    public $kind;
    public $block;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kind', 'block'], 'integer'],
            [['disciplineCode', 'name'], 'safe'],
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
    public function search($id_program, $params)
    {
        $query = DisciplineName::find()->where(['id_program_main' => $id_program]);
        $subQuery = DisciplineSemester::find()->
                    select('id_discipline, MIN(semester) as min_semester')->
                    groupBy('id_discipline');
        $query->leftJoin(['discSemester' => $subQuery],
            'discSemester.id_discipline = discipline_name.id_discipline' );

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $provider->setSort([
            'attributes' => [
                'name',
                'disciplineCode'=>[
                    'asc' => ['discipline.code' => SORT_ASC,'suffix' => SORT_ASC],
                    'desc' => ['discipline.code' => SORT_DESC,'suffix' => SORT_DESC],
                    'label'=>'DisciplineCode',
                ],
                'kind',
                'block',
                'disciplineSemesters' => [
                    'asc' => ['discSemester.min_semester' => SORT_ASC],
                    'desc' => ['discSemester.min_semester' => SORT_DESC],
                    'label'=>'DisciplineSemester',
                ]
            ],
            'defaultOrder' => ['disciplineCode' => SORT_ASC,]
        ]);

        if (!($this->load($params) && $this->validate())) {
            /**
             * The following line will allow eager loading with country data
             * to enable sorting by country on initial loading of the grid.
             */
            $query->joinWith(['idDiscipline']);
            return $provider;
        }

        $query->andWhere('name LIKE "%' . $this->name . '%" ');
        $query->joinWith(['idDiscipline' => function ($q) {
                /* @var $q \yii\db\ActiveQuery */
                $q->andWhere('discipline.code LIKE "%'. $this->disciplineCode . '%" ');
                if (is_numeric($this->kind)) {
                    $q->andWhere('discipline.kind = '. $this->kind);
                }
                if (is_numeric($this->block)) {
                    $q->andWhere('discipline.block = '. $this->block);
                }
            }
            ]);
        return $provider;

    }

} 