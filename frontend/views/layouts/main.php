<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\helpers\YearHelper;
use yii\bootstrap\Modal;
use kartik\icons\Icon;
use frontend\widgets\JumboWidget;

/* @var $this \yii\web\View */
/* @var $content string */

Icon::map($this);
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
            'brandLabel' => '<span class="brand_text">Результаты освоения образовательных программ</span>',
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'id' => 'mainMenu',
				'class' => 'navbar-fixed-top',
            ],
        ]);
		
		$menuItems = [
			YearHelper::getDropDownArray(),
		];
		
        if (Yii::$app->user->isGuest) {
			$msg =
				['label' => 'Войти '.Icon::show('sign-in'),
				'url' => ['/site/login'],
				'class' => 'navbar-link',
				];
        }
        else {
			$msg =
				['label' => Yii::$app->user->identity->username.' '.Icon::show('sign-out'),
				'url' => ['/site/logout'],
				'class' => 'navbar-link',
				];
        }
		
		$menuItems[] = $msg;
		
        echo Nav::widget([
            'options' => ['id' => 'mainNav','class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
			'encodeLabels' => false,
        ]);
		
        NavBar::end();
        ?>
		
		<div class="jumbotron">
			<div class="container">
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>

                <?= JumboWidget::widget(); ?>
			</div>
		</div>
			<div class="container">
			
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
