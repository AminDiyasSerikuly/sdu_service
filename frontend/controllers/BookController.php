<?php

namespace frontend\controllers;

use common\models\BookSentences;
use common\models\Book;
use common\models\BookSearch;
use common\models\User;
use common\models\BookFiles;
use http\Exception;
use Yii;
use yii\base\ErrorException;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/** @var BookFiles $book_files */

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Book();
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
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
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();
        $user = User::find()->where(['id' => Yii::$app->user->getId()]);
        if ($model->load(Yii::$app->request->post())) {
            $model->is_read = false;
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->save()) {
                    $this->fileMoveFromTemp($model);
                    $fileList = $model->fileArray;
                    foreach ($fileList as $fileName) {
                        $book_files = new BookFiles();
                        $book_files->name = $fileName;
                        $book_files->book_id = $model->id;
                        $book_files->save();
                    }
                }
                $book_file = BookFiles::find()->where(['book_id' => $model->id])->one();

                $file_content = file_get_contents('img/image_uploads/' . $book_file->name);
                $splittedText = $this->multiexplode(array(".", "?", "!"), $file_content);
                if (($key = array_search('', $splittedText)) !== false) {
                    unset($splittedText[$key]);
                }
                $order_num = 0;
                foreach ($splittedText as $text) {
                    $bookSentences = new BookSentences();
                    $bookSentences->book_id = $model->id;
                    $bookSentences->body = $text;
                    $bookSentences->is_deleted = false;
                    $bookSentences->order_num = $order_num;
                    $bookSentences->save(false);
                    $order_num += 1;
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw  $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw  $e;
            }


            return $this->redirect(['audio/record-audio', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    private function multiexplode($delimiters, $string)
    {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    private function fileMoveFromTemp(Book $model)
    {
        $fromDirectory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
        $toDirectory = Yii::getAlias('@frontend/web/img/image_uploads') . DIRECTORY_SEPARATOR;
        if (!is_dir($toDirectory)) {
            try {
                FileHelper::createDirectory($toDirectory, '777');
            } catch (\yii\base\Exception $e) {
            }
        }
        $fileNames = $this->getFileNames($fromDirectory);
        foreach ($fileNames as $fileName) {
            $fromPath = $fromDirectory . $fileName;
            $toPath = $toDirectory . $fileName;
            if (\rename($fromPath, $toPath)) {
                /** Save $filenames in attribute fileArray if files moved from temp*/
                array_push($model->fileArray, $fileName);
            }
        }

        /** remove temp directory if is empty */
        if (count(glob($fromDirectory . '/*')) === 0) {
            try {
                FileHelper::removeDirectory($fromDirectory);
            } catch (ErrorException $e) {
            }
        };
    }

    private function getFileNames($directory)
    {
        $resultList = [];
        if (is_dir($directory)) {
            $resultList = scandir($directory);
            if (($key = array_search('.', $resultList)) !== false) {
                unset($resultList[$key]);
            }
            if (($key = array_search('..', $resultList)) !== false) {
                unset($resultList[$key]);
            }
        }
        return $resultList;
    }

    /**
     * Updates an existing Book model.
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
     * Deletes an existing Book model.
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
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImageUpload()
    {

        $model = new Book();
        $imageFile = UploadedFile::getInstance($model, 'image');

        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (!is_dir($directory)) {
            try {
                FileHelper::createDirectory($directory, 0755, true);
            } catch (\yii\base\Exception $e) {
            }
        }
        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => 'image-delete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }

        return '';
    }

    public function actionImageDelete($name)
    {
        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
        }

        $files = FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file) {
            $fileName = basename($file);
            $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
            $output['files'][] = [
                'name' => $fileName,
                'size' => filesize($file),
                'url' => $path,
                'thumbnailUrl' => $path,
                'deleteUrl' => 'image-delete?name=' . $fileName,
                'deleteType' => 'POST',
            ];
        }
        return Json::encode($output);
    }
}
