<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center site-login">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'user']); ?>
                            <div class="form-group">
                                <?= $form->field($model, 'username')->textInput(
                                    [
                                        'autofocus' => true,
//                                        'type' => 'email',
                                        'class' => 'form-control form-control-user',
                                        'id' => 'exampleInputEmail',
                                        'aria-describedby' => 'emailHelp',
                                        'placeholder' => "Enter Username ..."
                                    ]) ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model, 'password')->textInput(
                                    [
                                        'class' => 'form-control form-control-user',
                                        'id' => 'exampleInputPassword',
                                        'placeholder' => 'Password',
                                        'type' => 'password',
                                    ]
                                ); ?>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck">Remember Me</label>
                                </div>
                            </div>
                            <?= Html::submitButton('Login', [
                                'class' => 'btn btn-primary btn-user btn-block'
                            ]) ?>

                            <hr>
                            <a href="index.html" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-google fa-fw"></i> Login with Google
                            </a>
                            <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                            </a>
                            <?php ActiveForm::end(); ?>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="register.html">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
