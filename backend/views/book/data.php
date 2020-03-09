<?php

use common\models\BookSentences;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var BookSentences $wholeSentences */
$readSentences = count($sentences);
$wholeSentences = count($wholeSentences);
$restSentences = ($wholeSentences - $readSentences);
$this->title = 'Книги';
if ($restSentences == 0) {
    $this->title = 'Книги полностью прочитано';
}
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="/js/audiojs/audio.min.js">
</script>
<script>
    audiojs.events.ready(function () {
        audiojs.createAll();
    });
</script>
<h1 class="<?= !$restSentences ? 'text-success' : '' ?>"><?= Html::encode($this->title) ?></h1>
<div>
    <span class="badge badge-primary">Все: <?= $wholeSentences ?></span>
    <span class="badge badge-success">Прочитано: <?= $readSentences ?></span>
    <span class="badge badge-warning">Осталось: <?= $restSentences ?></span>
</div>
<div>
    <div class="text-right" style="margin-bottom: 10px;color: white;">
        <a class="btn btn-success"
           href="<?= Url::to(['/book/record-audio', 'id' => Yii::$app->request->get('id')]) ?>">
            Просмотр книги
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="row" style="font-weight: bold;">
            <div class="col-sm-3">
                Приложение книги
            </div>
            <div class="col-sm-4">
                Аудиозапись
            </div>
            <div class="col-sm-3 text-center">
                Дата создание
            </div>
            <div class="col-sm-2">
                <a href="<?= Url::to(['/book/data-download', 'id' => Yii::$app->request->get('id')]); ?>"
                   class="text-decoration-none">Скачать все &nbsp; <i class="fas fa-download"></i></a>
            </div>
        </div>
    </div>
    <?php /** @var BookSentences $sentence */
    foreach ($sentences as $sentence):?>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card p-2">
                        <p>
                            <?= $sentence->body ?>
                        </p>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div id="" class="audio text-center align-middle">
                        <audio preload="auto">
                            <source src="<?= '/audio' . DIRECTORY_SEPARATOR . $sentence->audio->name ?>">
                        </audio>
                    </div>
                </div>
                <div class="col-sm-3 text-center">
                    <span class="badge badge-pill badge-success"> <?= date('d-m-Y H:i:s', $sentence->audio->created_at) ?></span>
                </div>
                <div class="col-sm-2">
                    <a href="<?= Url::to(['/book/data-download-single', 'id' => $sentence->id]) ?> "
                       class="badge badge-pill badge-primary" style="cursor: pointer;">
                        Скачать &emsp; <i class="fas fa-download"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>



