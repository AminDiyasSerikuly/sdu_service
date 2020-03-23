<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <span class="d-block d-sm-block d-md-none d-lg-none d-xl-none badge badge-primary"
          style="width: 100%; font-size: 90%;">You can scroll table <i class="fa fa-arrow-right"></i> </span>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'overflow-x: auto;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', [
                    User::STATUS_ACTIVE => 'активный',
                    User::STATUS_INACTIVE => 'не активный',
                    User::STATUS_DELETED => 'удален',
                ], ['class' => 'form-control', 'prompt' => 'выберите статус']),
                'value' => function ($model) {
                    switch ($model->status) {
                        case User::STATUS_ACTIVE:
                            return Html::button('активный', ['class' => 'badge badge-pill badge-success ']);
                            break;
                        case User::STATUS_INACTIVE:
                            return Html::button('не активный', ['class' => 'badge badge-pill badge-warning ']);
                            break;
                        default :
                            return Html::button('удален', ['class' => 'badge badge-pill badge-danger ']);
                            break;
                    }
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'role',
                'value' => function ($model) {
                    $role = !empty(Yii::$app->authManager->getAssignments($model->id)) ?
                        (array_values(Yii::$app->authManager->getAssignments($model->id)))[0]->roleName : NULL;
                    if ($role) {
                        return Html::tag('span', $role, ['claass' => 'badge badge-pill badge-primary']);
                    } else {
                        return 'Не задано';
                    }

                },
                'filter' => false,
                'format' => 'raw',
            ],
            [
                'attribute' => 'gender',
                'value' => function ($model) {
                    return '<span class="badge ' . ($model->gender ? 'badge-primary' : 'badge-warning') . '">' . ($model->gender ? 'Мужчина' : 'Женщина') . '</span>';
                },
                'label' => 'Пол',
                'format' => 'raw',
            ],
            [
                'attribute' => 'age',
                'value' => function ($model) {
                    return $model->age . '&nbsp;' . 'лет';
                },
                'label' => 'Возраст',
                'format' => 'raw',
            ],
            [
                'attribute' => 'read_sentences',
                'value' => function ($model) {
                    return Html::tag('span', count($model->audio), ['class' => 'badge badge-primary']);
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
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-eye"></span>',
                            Url::to(['user/read-book', 'id' => $model->id]), [
                            'title' => 'Full Details',
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
