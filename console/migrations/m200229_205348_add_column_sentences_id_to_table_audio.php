<?php

use yii\db\Migration;

/**
 * Class m200229_205348_add_column_sentences_id_to_table_audio
 */
class m200229_205348_add_column_sentences_id_to_table_audio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!\yii\helpers\ArrayHelper::isIn('sentences_id', $this->db->getTableSchema('audio', true)->getColumnNames())) {
            $this->addColumn('audio', 'sentences_id', $this->integer());
            $this->addForeignKey(
                'fk-audio-sentences_id',
                'audio',
                'sentences_id',
                'book_sentences',
                'id'
            );

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200229_205348_add_column_sentences_id_to_table_audio cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200229_205348_add_column_sentences_id_to_table_audio cannot be reverted.\n";

        return false;
    }
    */
}
