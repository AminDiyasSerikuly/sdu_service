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
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <span class="d-block d-sm-block d-md-none d-lg-none d-xl-none badge badge-primary" style="width: 100%; font-size: 90%;">You can scroll table <i class="fa fa-arrow-right"></i> </span>
    <?php if (Yii::$app->user->can('admin')): ?>
        <p>
            <?= Html::a('Добавить книги', Url::toRoute(['book/create']), ['class' => 'btn btn-success', 'style' => 'margin-top:10px;']) ?>
        </p>
    <?php endif; ?>
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
                'attribute' => 'updated_at',
                'format' => 'date',
                'filter' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $linkTo = 'data?id=' . $model->id;
                        return Html::a(Html::button('<span class="fas fa-eye"></span>',
                            ['class' => 'btn btn-default '])
                            , Url::to($linkTo));
                    },
                    'delete' => function ($url, $model, $key) {
                        $linkTo = ['book/delete', 'id' => $model->id];
                        return Html::a(
                            Html::button(
                                Html::tag('span', '', ['class' => 'fas fa-trash', 'style' => 'color:red;']),
                                ['class' => 'btn btn-default']
                            ),
                            Url::to($linkTo), ['data-confirm' => "Are you sure you want to delete this item?", 'data-method' => "post"]);
                    },
//                    'update' => function ($url, $model, $key) {
//                        $linkTo = '/book/update?id=' . $model->id;
//                        return Html::a(
//                            Html::button(
//                                Html::tag('span', '', ['class' => 'fas fa-edit', 'style' => 'color:blue;']),
//                                ['class' => 'btn btn-default']
//                            ),
//                            Url::to($linkTo));
//                    }
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
