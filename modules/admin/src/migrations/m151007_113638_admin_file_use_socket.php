<?php

use yii\db\Migration;

class m151007_113638_admin_file_use_socket extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_storage_file', 'passthrough_file', $this->boolean()->defaultValue(0));
        $this->addColumn('admin_storage_file', 'passthrough_file_password', $this->string(40));
        $this->addColumn('admin_storage_file', 'passthrough_file_stats', $this->integer(11)->defaultValue(0));
    }

    public function safeDown()
    {
    	$this->dropColumn('admin_storage_file', 'passthrough_file');
    	$this->dropColumn('admin_storage_file', 'passthrough_file_password');
    	$this->dropColumn('admin_storage_file', 'passthrough_file_stats');
    }
}
