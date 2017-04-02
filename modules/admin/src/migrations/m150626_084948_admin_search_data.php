<?php

use yii\db\Migration;

class m150626_084948_admin_search_data extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_search_data', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'timestamp_create' => $this->integer(11)->notNull(),
            'query' => $this->string(255)->notNull(),
            'num_rows' => $this->integer(11)->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_search_data');
    }
}
