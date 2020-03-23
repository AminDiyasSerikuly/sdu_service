<?php

use common\models\BookSentences;
use common\models\User;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var BookSentences $wholeSentences */
/** @var Pagination $pages */

$counter = $pages->offset + 1;
$readSentences = count($readSentences);
$wholeSentences = count($wholeSentences);
$restSentences = ($wholeSentences - $readSentences);
$this->title = 'Книги';
if ($restSentences == 0 && Yii::$app->controller->id == 'book') {
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
    <?php if (Yii::$app->controller->id == 'book'): ?>
        <span class="badge badge-primary">Все: <?= $wholeSentences ?></span>
    <?php endif; ?>
    <span class="badge badge-success">Прочитано: <?= $readSentences . (!(Yii::$app->controller->id == 'book') ?
            ' через ' . $model->fullname : '') ?> </span>
    <?php if (Yii::$app->controller->id == 'book'): ?>
        <span class="badge badge-warning">Осталось: <?= $restSentences ?></span>
    <?php endif; ?>
</div>
<div style="margin-top: 10px;">
    <div class="text-right" style="margin-bottom: 10px;color: white;">
        <a class="btn btn-success"
           href="<?= Url::to(['/book/record-audio', 'id' => Yii::$app->request->get('id')]) ?>">
            Просмотр книги
        </a>
    </div>
</div>
<div class="table">
    <div>
        Показаны записи <?= $pages->offset + 1 ?> - <?= ($pages->offset) + count($sentences) ?> из <?= $readSentences ?>
        .
    </div>
    <div class="card" style=" overflow-y: auto; overflow-x: auto;">
        <div class="card-header">
            <div class="row" style="font-weight: bold;">
                <div class="col-sm-3 d-none d-sm-none d-md-inline-block d-lg-inline-block d-xl-inline-block">
                    Предложении книги
                </div>
                <div class="col-sm-4 col-md-5 col-lg-4  d-none d-sm-none d-md-inline-block d-lg-inline-block d-xl-inline-block">
                    Аудиозапись
                </div>
                <div class="col-sm-2  d-none d-sm-none d-md-none d-lg-inline-block d-xl-inline-block text-center">
                    Дата создание
                </div>
                <div class="col-sm-2">
                    <a href="<?= Url::to(['/book/data-download', 'id' => Yii::$app->request->get('id')]); ?>"
                       class="text-decoration-none"> <span class="d-none d-sm-none d-md-none d-lg-block d-xl-block">Скачать все &nbsp;</span>
                        <i class="fas fa-download"></i></a>
                </div>
                <div class="col-sm-1">

                </div>
            </div>
        </div>
        <?php /** @var BookSentences $sentence */
        foreach ($sentences as $sentence): ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card p-2">
                            <p>
                                <?= $sentence->body ?>
                            </p>
                            <p class="p-0 m-0"><span
                                        class="float-right badge badge-secondary">&#8470; <?= $counter++; ?></span></p>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-5 col-lg-4 col-xl-4 col-12 text-center">
                        <div id="" class="audio text-center align-middle">
                            <audio preload="auto">
                                <source src="<?= '/audio' . DIRECTORY_SEPARATOR . $sentence->audio->name ?>">
                            </audio>
                        </div>
                    </div>
                    <div class="col-sm-2 text-center d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <span class="badge badge-pill badge-success"> <?= date('d-m-Y H:i:s', $sentence->audio->created_at) ?></span>
                    </div>
                    <div class="col-sm-2 col-md-2 mt-sm-3 mt-3 mt-md-0 mt-lg-0 mt-xl-0">
                        <a href="<?= Url::to(['/book/data-download-single', 'id' => $sentence->id]) ?> "
                           class="badge badge-pill badge-primary text-center" style="cursor: pointer;">
                            <span class="d-inline-block d-sm-none d-md-none d-lg-inline-block d-xl-inline-block">Скачать &emsp;</span>
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    <div class="col-sm-1">
                        <a href="<?= Url::to(['/book/data-delete', 'id' => $sentence->id]) ?> "
                           class="badge badge-pill badge-danger" style="cursor: pointer;"
                           data-confirm="Уверены, что хотите удалить?">
                            <span class="d-inline-block d-sm-none d-md-none d-lg-inline-block d-xl-inline-block">Удалить &emsp;</span>
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 certain-pagination">
                    <?= LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .certain-pagination {
        overflow-y: auto;
        overflow-x: auto;
    }
</style>


