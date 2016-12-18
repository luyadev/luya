<?php

use yii\db\Migration;

class m150331_125022_admin_ngrest_log extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_ngrest_log', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'timestamp_create' => $this->integer(11)->notNull(),
            'route' => $this->string(80)->notNull(),
            'api' => $this->string(80)->notNull(),
            'is_update' => $this->boolean()->defaultValue(0),
            'is_insert' => $this->boolean()->defaultValue(0),
            'attributes_json' => $this->text()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_ngrest_log');
    }
}
