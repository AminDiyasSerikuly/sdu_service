<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Audio */
/* @var $book frontend\models\Book */
/** @var string|array $sentences */

$this->title = 'Запись аудио';
$this->params['breadcrumbs'][] = ['label' => 'Audios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audio-create">
    <?=
    $this->render('audio_record', [
        'model' => $model,
        'book' => $book,
        'user' => $user,
        'sentences' => $sentences,
    ]) ?>
</div>
