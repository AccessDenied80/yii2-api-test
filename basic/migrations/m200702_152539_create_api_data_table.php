<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%api_data}}`.
 */
class m200702_152539_create_api_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%api_data}}', [
            'id' => $this->string(128),
            'internal_id' => $this->integer(),
            'last_modify' => $this->dateTime(),
            'regulator' => $this->text(),
        ]);

        $this->createIndex('idx-api-data-id', '{{%api_data}}', 'id');
        $this->createIndex('idx-api-data-last_modify', '{{%api_data}}', 'last_modify');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%api_data}}');
    }
}
