<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\DisciplineSemester;
use common\models\Discipline;

/* @var $program common\models\Program */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel frontend\modules\discipline\models\DisciplineSearch */

$this->title = 'Дисциплины';
$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program/main/index',
        'id_faculty' => $program->id_faculty],
];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $program;
$this->params['header'] = $program->fullName;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'disciplineCode',
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                return Html::a($model->name,
                    ['/file/main/discipline','id' => $model->id],
                    ['class' => 'linkedFiles',
                     'data-toggle' => 'tooltip',
                     'title' => 'Документы',
                    ]);
                }
        ],
        [
            'attribute' => 'kind',
            'format' => 'text',
            'value' => function($model, $key, $index, $column) {
                    return Yii::$app->params['decode']['discipline.kind'][$model->kind];
                },
            'filter' => Html::activeDropDownList($searchModel,
                        'kind',
                        Yii::$app->params['decode']['discipline.kind'],
                        ['prompt' => 'Поиск','class' => 'form-control'])
        ],
        [
            'attribute' => 'block',
            'format' => 'text',
            'value' => function($model, $key, $index, $column) {
                    return  Yii::$app->params['decode']['discipline.block'][$model->block];
                },
            'filter' => Html::activeDropDownList($searchModel,
                    'block',
                    Yii::$app->params['decode']['discipline.block'],
                    ['prompt' => 'Поиск','class' => 'form-control'])
        ],
        [
            'attribute' => 'disciplineSemesters',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                $content = '';
                $semesters = explode(', ',$model->disciplineSemesters);
                    foreach ($semesters as $semester) {
                        /* @var $disciplineSemester common\models\DisciplineSemester */
                        $disciplineSemester = DisciplineSemester::findOne([
                            'id_discipline' => $model->id_discipline,
                            'semester' => $semester
                            ]);

                        if ($disciplineSemester) {
                            $options = ['style'=>'margin-right:10px;',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Результаты',
                                       ];

                            if (Yii::$app->user->
                                can('viewFaculty',['id_faculty' => $model->idProgram->id_faculty])) {

                                $id_discipline_name = $model->idDiscipline->block == Discipline::DISCIPLINE_CHOICE ?
                                                    $model->id : null;

                                $content .= Html::a($semester,
                                   [
                                      '/student/result/discipline',
                                      'id' => $disciplineSemester->id,
                                      'id_discipline_name' => $id_discipline_name
                                   ],$options);
                            }
                            else {
                                $content .= Html::tag('span',$semester,$options);
                            }
                        }
                    }
                    return $content;
                }

        ]
    ],
    'summary' => ''
]);


?>