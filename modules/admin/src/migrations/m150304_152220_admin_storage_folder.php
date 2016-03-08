<?php

use yii\db\Schema;
use yii\db\Migration;

class m150304_152220_admin_storage_folder extends Migration
{
    public function up()
    {
        $this->createTable('admin_storage_folder', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING,
            'parent_id' => Schema::TYPE_INTEGER,
            'timestamp_create' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        echo "m150304_152220_admin_storage_folder cannot be reverted.\n";

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
