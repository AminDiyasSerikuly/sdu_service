<?php

namespace backend\controllers;

use common\models\BookSentences;
use common\models\Book;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'dash-board'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */


    private function convert($size)
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    private function folderSize($dir)
    {
        $size = 0;

        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }

        return $size;
    }


    public function actionIndex()
    {
        $allBookCount = Book::find()->count();
        $readBookCount = Book::find()->where(['is_read' => true])->count();
        $allSentences = BookSentences::find()->count();
        $readSentencesCount = BookSentences::find()->where(['is_deleted' => true])->count();
        $sizeAudioText = $this->convert($this->folderSize(Yii::getAlias('@frontend/web/audio')));
        $sizeBook = $this->convert($this->folderSize(Yii::getAlias('@frontend/web/img/image_uploads')));
        return $this->render('information', [
            'allBookCount' => $allBookCount,
            'readBookCount' => $readBookCount,
            'allSentences' => $allSentences,
            'readSentencesCount' => $readSentencesCount,
            'sizeAudioText' => $sizeAudioText,
            'sizeBook' => $sizeBook,
        ]);
    }

    /**
     * Displays dashboard panel.
     *
     * @return string
     */
    public function actionDashBoard()
    {
        return $this->redirect(Yii::$app->urlManagerFrontend->createUrl('/site/'));
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->urlManagerFrontend->createUrl('/'));
    }

}
