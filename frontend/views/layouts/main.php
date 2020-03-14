<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->registerCssFile('/backend/web/dashboard/css/sb-admin-2.min.css'); ?>
    <?php $this->registerCssFile('/backend/web/dashboard/vendor/fontawesome-free/css/all.css'); ?>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>


</head>
<body>
<nav class=" bg-light">
    <div class="container p-2 p-sm-2 p-md-none p-lg-none p-xl-none">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                <img src="https://moodle.sdu.edu.kz/pluginfile.php/1/theme_moove/logo/1582111407/moodle-logo-white.png"
                     width="70" height="30" class="d-inline-block align-top" alt="">
                <span style="font-size: 110%;" class="d-none d-sm-none d-md-none d-lg-inline-block d-xl-inline-block">AudioRecording</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                </ul>
                <ul class=" navbar-nav my-2 my-lg-0">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li> <?= Html::a('Регистрация', Url::to(['/site/signup']), ['class' => 'btn btn-button']) ?></li>
                        <li><?= Html::a('Вход', Url::to(['/site/login']), ['class' => 'btn btn-button']) ?></li>
                    <?php else: ?>
                        <?php if (Yii::$app->user->can('admin')): ?>
                            <li><?php echo Html::a('Панель управление', '/admin', ['class' => 'btn btn']) ?></li>
                        <?php endif; ?>
                        <li>  <?php echo Html::beginForm(['/site/logout'], 'post')
                                . Html::submitButton(
                                    'Выход',
                                    [
                                        'class' => 'btn btn-button logout',
                                        'style' => 'font-size:100%;'
                                    ]
                                )
                                . Html::endForm();
                            ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</nav>

<?php $this->beginBody() ?>
<div class="container p-2 p-sm-2 p-md-none p-lg-none p-xl-none">
    <?= $content ?>
</div>
<?php $this->endBody() ?>
<footer style="background-color: #f8f9fc; padding: 2rem 0 2rem 0;">
    <div class="container text-center">
        <strong>
            Developed By Diyas Amin 2019
        </strong>
    </div>

</footer>
</body>
</html>
<?php $this->endPage() ?>

<style>
    .grid-view {
        overflow-x: auto;
        overflow-y: auto;
    }
</style>
