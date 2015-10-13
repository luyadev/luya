<?php

use yii\db\Schema;
use yii\db\Migration;

class m150304_152238_admin_storage_file extends Migration
{
    public function up()
    {
        $this->createTable('admin_storage_file', [
            'id' => 'pk',
            'is_hidden' => Schema::TYPE_BOOLEAN.' default 0',
            'folder_id' => Schema::TYPE_INTEGER.' default 0',
            'name_original' => Schema::TYPE_STRING,
            'name_new' => Schema::TYPE_STRING,
            'name_new_compound' => Schema::TYPE_STRING,
            'mime_type' => Schema::TYPE_STRING, // @TODO should be an integere value from another table?
            'extension' => Schema::TYPE_STRING,
            'hash_file' => Schema::TYPE_STRING,
            'hash_name' => Schema::TYPE_STRING,
            'upload_timestamp' => 'int(11) NOT NULL default 0',
            'file_size' => 'int(11) default 0', // in bytes
            'upload_user_id' => 'int(11) default 0',
            'is_deleted' => 'tinyint(1) NOT NULL default 0',
        ]);
    }

    public function down()
    {
        echo "m150304_152238_admin_storage_file cannot be reverted.\n";

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
