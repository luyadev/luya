<?php

use yii\db\Migration;

class m160915_081618_create_admin_logger_table extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('admin_logger', [
            'id' => $this->primaryKey(),
            'time' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'type' => $this->integer(11)->notNull(),
            'trace_file' => $this->string(255),
            'trace_line' => $this->string(255),
            'trace_function' => $this->string(255),
            'trace_function_args' => $this->text(),
            'group_identifier' => $this->string(255),
            'group_identifier_index' => $this->integer(11),
            'get' => $this->text(),
            'post' => $this->text(),
            'session' => $this->text(),
            'server' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_logger');
    }
}
