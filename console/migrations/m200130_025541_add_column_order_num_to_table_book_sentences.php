<?php

use yii\db\Migration;

/**
 * Class m200130_025541_add_column_order_num_to_table_book_sentences
 */
class m200130_025541_add_column_order_num_to_table_book_sentences extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('book_sentences', 'order_num', $this->integer(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200130_025541_add_column_order_num_to_table_book_sentences cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_025541_add_column_order_num_to_table_book_sentences cannot be reverted.\n";

        return false;
    }
    */
}
