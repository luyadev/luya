<?php


use yii\db\Migration;

class m150304_152238_admin_storage_file extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_storage_file', [
            'id' => $this->primaryKey(),
            'is_hidden' => $this->boolean()->defaultValue(false),
            'folder_id' => $this->integer(11)->defaultValue(0),
            'name_original' => $this->string(255),
            'name_new' => $this->string(255),
            'name_new_compound' => $this->string(255),
            'mime_type' => $this->string(255),
            'extension' => $this->string(255),
            'hash_file' => $this->string(255),
            'hash_name' => $this->string(255),
            'upload_timestamp' => $this->integer(11),
            'file_size' => $this->integer(11)->defaultValue(0), // in bytes
            'upload_user_id' => $this->integer(11)->defaultValue(0),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'passthrough_file' => $this->boolean()->defaultValue(false),
            'passthrough_file_password' => $this->string(40),
            'passthrough_file_stats' => $this->integer(11)->defaultValue(0),
            'caption' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_storage_file');
    }
}
