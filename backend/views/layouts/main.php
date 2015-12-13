<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\helpers\YearHelper;
use yii\bootstrap\Modal;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Администрирование',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
        $menuItems = [
            YearHelper::getDropDownArray('Учебный год')
        ];

        if (! Yii::$app->user->isGuest) {
            $menuItems = array_merge($menuItems,[
               ['label' => ' Управление пользователями',
                    'url' => ['/user/main/index',
                              'idParent' => Yii::$app->user->identity->id_faculty],
               ],
               ['label' => Yii::$app->user->identity->username.' - Выход',
                'url' => ['/site/logout'],
               ]
            ]);
        }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; ПсковГУ <?= date('Y') ?></p>
        </div>
    </footer>

    <?php

    // Modal window declaration
    Modal::begin([
        'id' => 'modalWindow',
        'header' => '<h2></h2>',
        'options' => ['data-backdrop' => 'static']
    ]);

    Modal::end();
    ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
