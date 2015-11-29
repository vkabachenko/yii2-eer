<?php


namespace frontend\modules\discipline\models;

use common\models\DisciplineSemester;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DisciplineName;
use common\models\Discipline;

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

        $subQueryDiscipline = Discipline::find()->
            select('*,
                          cast([[code_last]] as decimal(10,3)) as [[code_last_num]]');

        $subQuerySemester = DisciplineSemester::find()->
                    select('id_discipline, MIN(semester) as min_semester')->
                    groupBy('id_discipline');

        $query->innerJoin(['discMain' => $subQueryDiscipline],
                'discMain.id = discipline_name.id_discipline')->
                leftJoin(['discSemester' => $subQuerySemester],
                'discSemester.id_discipline = discipline_name.id_discipline' );

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
                'pageSizeParam' => false,
            ],
        ]);

        $provider->setSort([
            'attributes' => [
                'name',
                'disciplineCode'=>[
                    'asc' => ['discMain.code_first' => SORT_ASC,
                              'discMain.code_last_num' => SORT_ASC,
                              'suffix' => SORT_ASC],
                    'desc' => ['discMain.code_first' => SORT_DESC,
                               'discMain.code_last_num' => SORT_DESC,
                               'suffix' => SORT_DESC],
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

            return $provider;
        }

        $query->andWhere('name LIKE "%' . $this->name . '%" ');
        $query->andWhere('discMain.code_first LIKE "%'. $this->disciplineCode . '%" ');
        if (is_numeric($this->kind)) {
            $query->andWhere('discMain.kind = '. $this->kind);
        }
        if (is_numeric($this->block)) {
            $query->andWhere('discMain.block = '. $this->block);
        }

        return $provider;

    }

} 