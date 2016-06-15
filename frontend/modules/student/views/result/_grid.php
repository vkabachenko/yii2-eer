<?php
use common\models\StudentResult;
use yii\widgets\DetailView;
use yii\helpers\Html;
use common\models\StudentResultFile;

/* @var $model StudentResult */
$this->params['model'] = $model;
$this->params['header'] = $model->idDisciplineSemester->idDiscipline->fullName;

?>

    <h3>
        <?= $model->idStudentEducation->studentName ?>, <?= $model->idStudentEducation->course ?> курс
        <?php if ($model->id_discipline_name): ?>
           <?= $model->idDisciplineName->name ?>
        <?php endif; ?>

    </h3>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'passing_date',
        'examiner',
        'assesment',
        'rating',
        [
            'label' => 'Макс. рейтинг',
            'value' => $model->idDisciplineSemester->max_rating,
        ]
    ]
]);
?>
<?php if (StudentResultFile::find()->where(['id_student_result' => $model->id])->exists()): ?>

    <p>
        <?= Html::a('Документы',
            ['/file/main/result','id' => $model->id],
            ['class' => 'linkedFiles']);
        ?>
    </p>

<?php endif; ?>