<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
$is_admin = User::find()->where(['id' => Yii::$app->user->getId()])->one();
$is_admin = $is_admin ? $is_admin->role : null;

?>
<div style="margin-top:15px;" >
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success card">
            <strong><?= Yii::$app->session->getFlash('success'); ?></strong>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('danger')): ?>
        <div class="alert alert-danger card">
            <strong><?= Yii::$app->session->getFlash('danger'); ?></strong>
        </div>
    <?php endif; ?>
</div>
<div class="book-index p-t-3">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <!--    <div class="card">-->
    <!--        <div class="card-body">-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'read_percentage',
                'value' => function ($model) {
                    return '<div class="progress" style="background-color: white;">
                                <div class="progress-bar progress-bar-success" 
                                     role="progressbar"
                                     aria-valuenow="' . $model->readPercentage . '"
                                     aria-valuemin="0"
                                     aria-valuemax="' . count($model->sentences) . '"
                                     style="font-weight:bold;background-color:lightgreen;color:black; width:' . $model->readPercentage . '%">
                                    ' . (int)$model->readPercentage . '%
                                </div>
                            </div>';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'format' => 'date',
                'filter' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $linkTo = 'data?id=' . $model->id;
                        return Html::a('Начать чтение', Url::to(['audio/record-audio', 'id' => $model->id]), ['class' => 'btn btn-success']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>

<?php
$css = <<<CSS
 .card{
        width: auto;
        height: auto;
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 1rem;
    }
CSS;
$this->registerCss($css);
?>
