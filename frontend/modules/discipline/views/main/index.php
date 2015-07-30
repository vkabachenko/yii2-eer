<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\DisciplineSemester;

/* @var $program common\models\Program */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel frontend\modules\discipline\models\DisciplineSearch */

$this->title = 'Дисциплины';
$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'id_faculty' => $program->id_faculty],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2>Дисциплины</h2>
<h3>
    Образовательная программа: <?= "$program->fullName" ?>
</h3>

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
                    ['class' => 'linkedFiles']);
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
                            $content .= Html::a($semester,
                               [
                                 '/student/result/discipline',
                                 'id' => $disciplineSemester->id ],
                                ['style'=>'margin-right:10px;']);
                        }
                    }
                    return $content;
                }

        ]
    ],
    'summary' => ''
]);


?>