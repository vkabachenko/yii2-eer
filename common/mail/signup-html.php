<?php
use yii\helpers\Html;

/* @var $login string */
/* @var $password string */

$link =  Yii::$app->urlManager->hostInfo;

?>
<p>Регистрация пользователя на сайте <?= Html::a("Результаты освоения образовательных программ ПсковГУ", $link) ?>
<p>Логин: <?= $login ?></p>
<p>Пароль: <?= $password ?></p>
