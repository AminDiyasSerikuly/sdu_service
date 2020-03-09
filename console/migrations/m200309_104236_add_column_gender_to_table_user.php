<?php

use yii\db\Migration;

/**
 * Class m200309_104236_add_column_gender_to_table_user
 */
class m200309_104236_add_column_gender_to_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!\yii\helpers\ArrayHelper::isIn('gender', $this->db->getTableSchema('user', true)->getColumnNames())) {
            $this->addColumn('user', 'gender', $this->tinyInteger());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200309_104236_add_column_gender_to_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200309_104236_add_column_gender_to_table_user cannot be reverted.\n";

        return false;
    }
    */
}
