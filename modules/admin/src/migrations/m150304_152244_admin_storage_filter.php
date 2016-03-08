<?php

use yii\db\Schema;
use yii\db\Migration;

class m150304_152244_admin_storage_filter extends Migration
{
    public function up()
    {
        $this->createTable('admin_storage_filter', [
            'id' => 'pk',
            'identifier' => 'VARCHAR(100) NOT NULL UNIQUE',
            'name' => Schema::TYPE_STRING,
        ]);
    }

    public function down()
    {
        echo "m150304_152244_admin_storage_filter cannot be reverted.\n";

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
