<?php

use yii\db\Migration;

class m151012_072207_cms_log extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_log', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(0),
            'is_insertion' => $this->boolean()->defaultValue(false),
            'is_update' => $this->boolean()->defaultValue(false),
            'is_deletion' => $this->boolean()->defaultValue(false),
            'timestamp' => $this->integer(11)->notNull(),
            'message' => $this->string(255),
            'data_json' => $this->text(),
            'table_name' => $this->string(120),
            'row_id' => $this->integer(11)->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_log');
    }
}
