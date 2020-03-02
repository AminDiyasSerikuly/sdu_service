<?php

use yii\db\Migration;

/**
 * Class m191123_120326_create_table_audio_to_db_audiorecording
 */
class m191123_120326_create_table_audio_to_db_audiorecording extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%audio}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->defaultValue(NULL)->comment('название аудио'),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191123_120326_create_table_audio_to_db_audiorecording cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191123_120326_create_table_audio_to_db_audiorecording cannot be reverted.\n";

        return false;
    }
    */
}
