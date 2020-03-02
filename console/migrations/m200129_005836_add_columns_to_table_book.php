<?php

use yii\db\Migration;

/**
 * Class m200129_005836_add_columns_to_table_book
 */
class m200129_005836_add_columns_to_table_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('book', 'dir_name', $this->tinyInteger());
        $this->addColumn('book', 'format', $this->tinyInteger());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200129_005836_add_columns_to_table_book cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200129_005836_add_columns_to_table_book cannot be reverted.\n";

        return false;
    }
    */
}
