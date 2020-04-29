<?php

namespace common\models;

use common\models\BookSentences;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string|null $name Название книги
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null dir_name
 * @property int|null format
 * @property BookSentences sentences
 * @property Audio audios
 * @property integer is_read
 * @property integer readPercentage
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $image;
    public $fileArray = [];
    public $read_percentage;

    const TYPE_ID_USERNAME = 1; // id + username
    const TYPE_ID_DATE = 2; //id + created date
    const TYPE_DIR_NAME = 3; // id + dir name

    const WAV = 1;
    const MP4 = 2;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'dir_name', 'format'], 'required'],
            ['name', 'unique'],
            [['created_at', 'updated_at'], 'integer'],
            [['is_read', 'read_percentage'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => 'Название книги (Наименование папки)',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'dir_name' => 'Структура наименование файлов',
            'format' => 'Формат аудио',
            'read_percentage' => 'Процент прочтение книги',
        ];
    }

    public function getAudios()
    {
        return $this->hasMany(Audio::className(), ['book_id' => 'id']);
    }

    public function getBookFiles()
    {
        return $this->hasOne(BookFiles::className(), ['book_id' => 'id']);
    }

    public function getSentences()
    {
        return $this->hasMany(BookSentences::className(), ['book_id' => 'id']);
    }

    public function getReadPercentage()
    {
        $readPercentage = 0;
        $allSentences = BookSentences::find()->where(['book_id' => $this->id])->count();
        $readSentences = BookSentences::find()->where(['book_id' => $this->id])->andWhere(['is_deleted' => true])->count();
        $readPercentage = $allSentences != 0 ? ($readSentences / $allSentences) * 100 : 0;
        return $readPercentage;
    }
}
