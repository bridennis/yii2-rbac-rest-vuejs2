<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Веб сервер попытался обработать ваш запрос, но во время его обработки возникла какая-то ошибка.
    </p>
    <p>
        Пожалуйста, если вы считаете, что это действительно ошибка сервера - напишите нам об этом на <b><?= Yii::$app->params['adminEmail']; ?></b>. Спасибо!
    </p>

</div>
