<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
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
            'brandLabel' => false,
            'options' => [
                'id' => 'authMenu',
                'class' => 'navbar-fixed-top',
            ],
        ]);

        if (Yii::$app->user->isGuest) {
            $msg = Html::a('Авторизация',['/site/login'],['class' => 'navbar-link']);
        }
        else {
            $msg = 'Вы зашли под именем <strong>'.Yii::$app->user->identity->username.'</strong>';
            $msg .= Html::a('Выход',['/site/logout'],['class' => 'navbar-link']);
        }

        echo Html::tag('p',$msg,['class' => "navbar-right"]);


        NavBar::end();
        ?>

        <?php
        NavBar::begin([
            'brandLabel' => Html::img('/images/gerb.gif',['width' => '60']).
                '<span>Результаты освоения образовательных программ ПсковГУ</span>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'id' => 'mainMenu',
                'class' => 'navbar-fixed-top',
            ],
        ]);

        echo Nav::widget([
            'options' => ['id' => 'mainNav','class' => 'navbar-nav navbar-right'],
            'items' => [YearHelper::getDropDownArray()],
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
