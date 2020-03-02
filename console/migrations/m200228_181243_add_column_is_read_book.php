<?php

use yii\db\Migration;

/**
 * Class m200228_181243_add_column_is_read_book
 */
class m200228_181243_add_column_is_read_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!\yii\helpers\ArrayHelper::isIn('is_read', $this->db->getTableSchema('book', true)->getColumnNames())) {
            $this->addColumn('book', 'is_read', $this->tinyInteger());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200228_181243_add_column_is_read_book cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200228_181243_add_column_is_read_book cannot be reverted.\n";

        return false;
    }
    */
}
