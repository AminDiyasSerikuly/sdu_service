<?php

use yii\db\Migration;

/**
 * Class m191202_092905_add_column_user_id_to_table_audio
 */
class m191202_092905_add_column_user_id_to_table_audio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = $this->db->getTableSchema('audio')->columns;
        if(!isset($columns['user_id'])){
            $this->addColumn('audio' , 'user_id' ,$this->integer());
        }

        $this->addForeignKey('fk-audio-user_id' , 'audio' , 'user_id' , 'user' , 'id');
        $this->createIndex('idx-audio-user_id' , 'audio', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191202_092905_add_column_user_id_to_table_audio cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191202_092905_add_column_user_id_to_table_audio cannot be reverted.\n";

        return false;
    }
    */
}
