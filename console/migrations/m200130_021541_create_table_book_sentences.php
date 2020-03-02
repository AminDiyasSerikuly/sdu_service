<?php

use yii\db\Migration;

/**
 * Class m200130_021541_create_table_book_sentences
 */
class m200130_021541_create_table_book_sentences extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book_sentences', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'body' => $this->string()->defaultValue(NULL),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);

        $this->addForeignKey('fk-book_sentences-book_id', 'book_sentences', 'book_id', 'book', 'id', 'cascade', 'cascade');
        $this->createIndex('idx-book_sentences-book_id', 'book_sentences', 'book_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200130_021541_create_table_book_sentences cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_021541_create_table_book_sentences cannot be reverted.\n";

        return false;
    }
    */
}
