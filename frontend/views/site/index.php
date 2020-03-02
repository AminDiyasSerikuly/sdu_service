<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php if (Yii::$app->user->isGuest): ?>
        <div class="jumbotron">
            <h1>Welcome to SDU audioRecording!</h1>

            <p class="lead">Для записи аудио пожалуйста пройдите регистрацию :) </p>

            <p><a class="btn btn-lg btn-success" href="book/index">Начать</a></p>
        </div>
    <?php endif; ?>
</div>
