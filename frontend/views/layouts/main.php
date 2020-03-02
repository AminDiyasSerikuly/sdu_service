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
    <!--    <script src="https://use.fontawesome.com/6e644806a3.js"></script>-->

    <?php $this->registerCssFile('/vendor/dashboard/css/sb-admin-2.min.css', ['rel' => 'stylesheet', 'type' => 'text/css']); ?>
    <?php $this->registerCssFile('/vendor/vendor/fontawesome-free/css/all.min.css', ['rel' => 'stylesheet', 'type' => 'text/css']); ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                <img src="https://moodle.sdu.edu.kz/pluginfile.php/1/theme_moove/logo/1582111407/moodle-logo-white.png"
                     width="70" height="30" class="d-inline-block align-top" alt="">
                <span style="font-size: 110%;">AudioRecording</span>
            </a>
        </nav>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
            </ul>

            <?php if (Yii::$app->user->isGuest): ?>
                <?= Html::a('Регистрация', Url::to(['/site/signup']), ['class' => 'btn btn-button']) ?>
                <?= Html::a('Вход', Url::to(['/site/login']), ['class' => 'btn btn-button']) ?>
            <?php else: ?>
                <?php echo Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        '<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>' . 'Выход',
                        [
                            'class' => 'btn btn-button logout',
                            'style' => 'font-size:100%;'
                        ]
                    )
                    . Html::endForm();
                ?>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php $this->beginBody() ?>
<div class="container">
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
