<?php

use yii\db\Migration;

/**
 * Class m191123_074114_create_table_book_to_db_audiorecording
 */
class m191123_074114_create_table_book_to_db_audiorecording extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->comment('Название книги'),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11)
         ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191123_074114_create_table_book_to_db_audiorecording cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191123_074114_create_table_book_to_db_audiorecording cannot be reverted.\n";

        return false;
    }
    */
}
