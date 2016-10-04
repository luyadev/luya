<?php

use yii\db\Migration;

class m151012_072207_cms_log extends Migration
{
    public function up()
    {
        $this->createTable('cms_log', [
            'id' => 'pk',
            'user_id' => 'int(11) default 0',
            'is_insertion' => 'tinyint(1) default 0',
            'is_update' => 'tinyint(1) default 0',
            'is_deletion' => 'tinyint(1) default 0',
            'timestamp' => 'int(11) NOT NULL',
            'message' => 'varchar(255)',
            'data_json' => 'text',
        ]);
    }

    public function down()
    {
        echo "m151012_072207_cms_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
