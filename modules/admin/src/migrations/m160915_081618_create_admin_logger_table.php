<?php

use yii\db\Migration;

class m160915_081618_create_admin_logger_table extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('admin_logger', [
            'id' => 'pk',
            'time' => 'int(11) NOT NULL',
            'message' => 'text NOT NULL',
            'type' => 'int(11) NOT NULL',
            'trace_file' => 'varchar(255)',
            'trace_line' => 'varchar(255)',
            'trace_function' => 'varchar(255)',
            'trace_function_args' => 'text',
            'group_identifier' => 'varchar(255)',
            'group_identifier_index' => 'int(11)',
            'get' => 'text',
            'post' => 'text',
            'session' => 'text',
            'server' => 'text',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_logger');
    }
}
