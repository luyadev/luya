<?php

use yii\db\Migration;

class m151007_113638_admin_file_use_socket extends Migration
{
    public function up()
    {
        $this->addColumn('admin_storage_file', 'passthrough_file', 'tinyint(1) default 0');
        $this->addColumn('admin_storage_file', 'passthrough_file_password', 'varchar(40)');
        $this->addColumn('admin_storage_file', 'passthrough_file_stats', 'int(11) default 0');
    }

    public function down()
    {
        echo "m151007_113638_admin_file_use_socket cannot be reverted.\n";

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
