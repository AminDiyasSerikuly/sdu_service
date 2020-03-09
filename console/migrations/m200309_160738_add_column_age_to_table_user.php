<?php

use yii\db\Migration;

/**
 * Class m200309_160738_add_column_age_to_table_user
 */
class m200309_160738_add_column_age_to_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!\yii\helpers\ArrayHelper::isIn('age', $this->db->getTableSchema('user', true)->getColumnNames())) {
            $this->addColumn('user', 'age', $this->integer());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200309_160738_add_column_age_to_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200309_160738_add_column_age_to_table_user cannot be reverted.\n";

        return false;
    }
    */
}
