<?php

namespace console\controllers;

use common\models\Book;
use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use ZipArchive;

class ZipAudioDirectoryController extends Controller
{
    public function actionZipAllBookDirectory()
    {
        /** @var Book $book */
        $books = Book::find()->all();
        foreach ($books as $bookKey => $book) {
            $dir_name = $book->name;
            $dir_path = Yii::getAlias('@frontend/web/audio' . DIRECTORY_SEPARATOR . $dir_name);
            $files = FileHelper::findFiles($dir_path);

            $tempArray = [];
            $fileArray = [];

            foreach ($files as $key => $val) {
                $file = basename($val);
                $tempArray[$key] = $file;
            }

            $needKeys = array_keys($tempArray);
            foreach ($needKeys as $val) {
                array_push($fileArray, $files[$val]);
            }

            $files = $fileArray;

            $dir_root_path = Yii::getAlias('@frontend/web/audio/cron_zip_files');
            $dir_path = $dir_root_path . DIRECTORY_SEPARATOR . $dir_name . '.zip';

            if (!is_dir($dir_path)) {
                FileHelper::createDirectory($dir_root_path, 0755, true);
            }

            $zip = new ZipArchive;
            $zip->open($dir_path, ZipArchive::CREATE);
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }


    }

}