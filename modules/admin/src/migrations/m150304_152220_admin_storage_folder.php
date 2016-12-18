<?php

use yii\db\Schema;
use yii\db\Migration;

class m150304_152220_admin_storage_folder extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_storage_folder', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'parent_id' => $this->integer(11),
            'timestamp_create' => $this->integer(11),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_storage_folder');
    }
}
