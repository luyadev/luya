<?php

use yii\db\Migration;

class m151007_084953_storage_folder_is_deleted extends Migration
{
    public function up()
    {
        $this->addColumn('admin_storage_folder', 'is_deleted', 'tinyint(1) NOT NULL default 0');
    }

    public function down()
    {
        echo "m151007_084953_storage_folder_is_deleted cannot be reverted.\n";

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
