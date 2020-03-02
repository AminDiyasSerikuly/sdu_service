<?php

use yii\db\Migration;

/**
 * Class m200228_183442_add_column_is_read_book_sentences
 */
class m200228_183442_add_column_is_read_book_sentences extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!\yii\helpers\ArrayHelper::isIn('is_read', $this->db->getTableSchema('book_sentences', true)->getColumnNames())) {
            $this->addColumn('book_sentences', 'is_read', $this->tinyInteger());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200228_183442_add_column_is_read_book_sentences cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200228_183442_add_column_is_read_book_sentences cannot be reverted.\n";

        return false;
    }
    */
}
