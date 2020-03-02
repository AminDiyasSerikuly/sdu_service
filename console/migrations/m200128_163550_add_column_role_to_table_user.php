<?php

use yii\db\Migration;

/**
 * Class m200128_163550_add_column_role_to_table_user
 */
class m200128_163550_add_column_role_to_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200128_163550_add_column_role_to_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200128_163550_add_column_role_to_table_user cannot be reverted.\n";

        return false;
    }
    */
}
