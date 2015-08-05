<?php

/**
 * @var yii\web\View            $this
 * @var kartik\tree\models\Tree $node
 */

use yii\helpers\Html;

extract($params);

?>

<h2>
    <?= $node->name ?>
</h2>

<?php

if ($node->filename) {
echo Html::tag('p',Html::a($node->document,[
'/student/portfolio/download',
'id' => $node->id,
'modelFile' => '\common\models\StudentPortfolio']));
}

?>
