<?php

use yii\db\Migration;

/**
 * Class m200225_185601_change_column_type_of_email_in_table_user
 */
class m200225_185601_change_column_type_of_email_in_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('email', 'user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200225_185601_change_column_type_of_email_in_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200225_185601_change_column_type_of_email_in_table_user cannot be reverted.\n";

        return false;
    }
    */
}
