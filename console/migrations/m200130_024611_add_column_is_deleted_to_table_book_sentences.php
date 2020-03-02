<?php

use yii\db\Migration;

/**
 * Class m200130_024611_add_column_is_deleted_to_table_book_sentences
 */
class m200130_024611_add_column_is_deleted_to_table_book_sentences extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('book_sentences', 'is_deleted', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200130_024611_add_column_is_deleted_to_table_book_sentences cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_024611_add_column_is_deleted_to_table_book_sentences cannot be reverted.\n";

        return false;
    }
    */
}
