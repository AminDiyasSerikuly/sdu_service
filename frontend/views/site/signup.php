<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7 p-0">
                <?php if ($model->errors): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?= Html::errorSummary($model, ['encode' => false]) ?>
                    </div>
                <?php endif; ?>
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Создать аккаунт!</h1>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-6 mb-sm-0">
                            <?= $form->field($model, 'username')->textInput([
                                'autofocus' => true,
                                'class' => 'form-control form-control-user',
                                'id' => 'exampleFirstName',
                                'placeholder' => 'User name',
                                'type' => 'text',
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <?= $form->field($model, 'gender',
                                ['wrapperOptions' => ['style' => 'display:inline-block;']])
                                ->inline(true)->radioList([
                                    User::MALE => 'Мужчина',
                                    User::FEMALE => 'Женщина',
                                ], ['separator' => '   ']); ?>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <?= $form->field($model, 'age')->textInput(); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <?= $form->field($model, 'password')->passwordInput(
                                [
                                    'type' => 'password',
                                    'class' => 'form-control form-control-user',
                                    'id' => 'exampleInputPassword',
                                    'placeholder' => 'Password',
                                ]
                            ) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'password_repeat')->passwordInput(
                                [
                                    'type' => 'password',
                                    'class' => 'form-control form-control-user',
                                    'id' => 'exampleRepeatPassword',
                                    'placeholder' => 'Repeat Password',
                                ]
                            ) ?>
                        </div>
                    </div>

                    <?= Html::submitButton('Регистрация аккаунта', [
                        'class' => 'btn btn-primary btn-user btn-block',
                        'name' => 'signup-button'
                    ]) ?>
                    <hr>
                    <a href="index.html" class="btn btn-google btn-user btn-block disabled">
                        <i class="fab fa-google fa-fw"></i> Вход через Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-user btn-block disabled">
                        <i class="fab fa-facebook-f fa-fw"></i> Вход через Facebook
                    </a>
                    <?php ActiveForm::end(); ?>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="<?= Url::to(['/site/login']) ?>">Уже зарегистрированы? Вход!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .help-block-error {
        color: red;
    }
</style>


