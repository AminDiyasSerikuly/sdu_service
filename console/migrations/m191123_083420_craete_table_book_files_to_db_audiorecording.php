<?php

use yii\db\Migration;

/**
 * Class m191123_083420_craete_table_book_files_to_db_audiorecording
 */
class m191123_083420_craete_table_book_files_to_db_audiorecording extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book_files', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'name' => $this->string()->comment('Название книги с его типом')->defaultValue(NULL),
            'file_type' => $this->string()->comment('Тип файла')->defaultValue(NULL),
            'directory' => $this->string()->comment('Директория к книги')->defaultValue(NULL),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
        $this->addForeignKey(
            'fk-book_files-book_id',
            'book_files',
            'book_id',
            'book',
            'id',
            'cascade',
            'cascade'
        );
        $this->createIndex(
            'idx-book_files-book_id',
            'book_files',
            'book_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191123_083420_craete_table_book_files_to_db_audiorecording cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191123_083420_craete_table_book_files_to_db_audiorecording cannot be reverted.\n";

        return false;
    }
    */
}
