<?php

use yii\db\Migration;

/**
 * Class m191201_174608_add_column_book_id_to_table_audio
 */
class m191201_174608_add_column_book_id_to_table_audio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('audio', 'book_id', $this->integer());
        $this->addForeignKey(
            'fk-audio-book_id',
            'audio',
            'book_id',
            'book',
            'id');

        $this->createIndex(
            'idx-audio-book_id',
            'audio',
            'book_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191201_174608_add_column_book_id_to_table_audio cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191201_174608_add_column_book_id_to_table_audio cannot be reverted.\n";

        return false;
    }
    */
}
