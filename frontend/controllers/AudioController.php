<?php

namespace frontend\controllers;

use common\models\BookSentences;
use common\models\User;
use common\models\Book;
use common\models\BookFiles;
use Yii;
use common\models\Audio;
use common\models\AudioSearch;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class AudioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];

    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        try {
            return parent:: beforeAction($action);
        } catch (BadRequestHttpException $e) {
        }
    }

    /**
     * Lists all Audio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AudioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Audio model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Audio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//        $model = new Audio();
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//        return $this->render('create', [
//            'model' => $model,
//        ]);
    }


    public function actionRecordAudio($id = null)
    {
        /** @var Book $book */
        $model = new Audio();
        $user = User::find()->where(['id' => Yii::$app->user->getId()]);
        $book = Book::find()->where(['id' => $id])->one();
        $book_sentences = BookSentences::find()->where(['book_id' => $id, 'is_deleted' => false])->all();
        if (!$book_sentences) {
            Yii::$app->session->setFlash('danger', 'Упс, это книга полностью прочитано!');

            if ($book && !$book->is_read) {
                $book->is_read = true;
                $book->save();
            }
        }
        if (!$book) {
            Yii::$app->session->setFlash('danger', 'Книга не найдена!');
        }
        $bookFiles = BookFiles::find()->where(['book_id' => $id])->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $sentences = BookSentences::find()->where(['book_id' => $id, 'is_deleted' => false])->all();
        $sentences = ArrayHelper::map($sentences, 'order_num', 'body');

        return $this->render('create', [
            'model' => $model,
            'book' => $book,
            'user' => $user,
            'sentences' => $sentences,
        ]);
    }

    private function multiexplode($delimiters, $string)
    {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    /**
     * Updates an existing Audio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Audio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Audio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Audio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Audio::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function uploadAudio()
    {
        /** @var Audio $audio */
        /** @var Book $book */
        /** @var BookSentences $book_sentences */
        $audio = new Audio();
        $boolean = false;
        $format = '.wav';
        $sortUrl = '';
        $input = $_FILES['audio_data']['tmp_name'];
        $sub_id = Yii::$app->request->post('sub_id');
        $book_id = Yii::$app->request->post('book_id');
        $book = Book::find()->where(['id' => $book_id])->one();
        $user = User::find()->where(['id' => Yii::$app->user->getId()])->one();
        $book_sentences = BookSentences::find()->where(['book_id' => $book_id, 'order_num' => $sub_id, 'is_deleted' => false])->one();

        if (!$book_sentences) {
            Yii::$app->session->setFlash('danger', 'Упс, данное приложение уже прочитано');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($book->format == Book::MP4) {
            $format = '.mp4';
        }
        $sortUrl = 'audio/' . htmlspecialchars_decode($book->name) . '/';

        switch ($book->dir_name) {
            case Book::TYPE_ID_USERNAME:
                $audioName = $sub_id . '_' . $user->username;
                $text_name = $sub_id . '_' . $user->username;
                break;
            case Book::TYPE_ID_DATE:
                $audioName = $sub_id . '_' . date('Y-m-d', $book_sentences->created_at);
                $text_name = $sub_id . '_' . date('Y-m-d', $book_sentences->created_at);
                break;
            case Book::TYPE_DIR_NAME:
                $audioName = $sub_id . '_' . $book->name;
                $text_name = $sub_id . '_' . $book->name;
                break;
        }
        $audioName = $audioName . $format;


        if (!is_dir($sortUrl)) {
            try {
                FileHelper::createDirectory($sortUrl, 0777, true);
            } catch (Exception $e) {
            }
        }
        $txtFilePath = $sortUrl . DIRECTORY_SEPARATOR . $text_name . '.txt';
        $fp = fopen($txtFilePath, "wb");
        fwrite($fp, $book_sentences->body);
        fclose($fp);
        chmod($txtFilePath, 0777);

        /** @var Audio $audio */
        /** @var Audio $isThereCheck */
        $output = $sortUrl . $audioName;
        $isThereCheck = Audio::find()->where(['book_id' => $book_id, 'sub_id' => $sub_id])->one();
        if (move_uploaded_file($input, $output) && chmod($output, 0777)) {
            if (!$isThereCheck) {
                $audio->name = $book->name . '/' . $audioName;
                $audio->sub_id = $sub_id;
                $audio->book_id = $book_id;
                $audio->user_id = Yii::$app->user->id;
                $audio->sentences_id = $book_sentences->id;
                if ($audio->save()) {
                    $boolean = true;
                };
            } else {
                $isThereCheck->name = $audioName;
                $isThereCheck->sub_id = $sub_id;
                $isThereCheck->book_id = $book_id;
                $isThereCheck->user_id = Yii::$app->user->id;

                $isThereCheck->sentences_id = $book_sentences->id;
                if ($isThereCheck->save()) {
                    $boolean = true;
                };
            }


            $book_sentences->is_deleted = true;
            if ($book_sentences->save(false)) {
                Yii::$app->session->setFlash('success', 'Аудиозапись успешно сохранен');
            };
            return $this->redirect(Yii::$app->request->referrer);
        }

    }

    private
    function getAudio()
    {
        if (Yii::$app->request->isAjax) {
            $book_id = Yii::$app->request->post('book_id');
            $book = Book::find()->where(['id' => $book_id])->one();
            $audioList = $book->audios;
            $array = [];
            foreach ($audioList as $audioKey => $audioValue) {
                $userAndNameArray = [];
                $userAndNameArray['username'] = $audioValue->user->username;
                $userAndNameArray['audio_path'] = $audioValue->name;
                $userAndNameArray['created_at'] = $audioValue->created_at;
                $userAndNameArray['updated_at'] = $audioValue->updated_at;
                $array[$audioKey] = $userAndNameArray;
            }
            $audioArray = ArrayHelper::map($audioList, 'sub_id', 'name');
            return $this->asJson([
                'success' => 1,
                'audioList' => $array,
            ]);


        }
    }

    public
    function actionIsAjax()
    {

        if (Yii::$app->request->isAjax) {
            $name = Yii::$app->request->post('name');
            switch ($name) {
                case 'uploadAudio':
                    $this->uploadAudio();
                    break;
                case 'getAudio':
                    $this->getAudio();
                    break;
            }
        }
    }
}
