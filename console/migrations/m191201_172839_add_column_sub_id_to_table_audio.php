<?php

use yii\db\Migration;

/**
 * Class m191201_172839_add_column_sub_id_to_table_audio
 */
class m191201_172839_add_column_sub_id_to_table_audio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = $this->db->getTableSchema('{{%audio}}')->columns;
//        if (!$columns['sub_id']) {
            $this->addColumn('{{%audio}}', 'sub_id', $this->integer());
//        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191201_172839_add_column_sub_id_to_table_audio cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191201_172839_add_column_sub_id_to_table_audio cannot be reverted.\n";

        return false;
    }
    */
}
