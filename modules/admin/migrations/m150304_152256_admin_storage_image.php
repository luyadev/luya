<?php

use yii\db\Schema;
use yii\db\Migration;

class m150304_152256_admin_storage_image extends Migration
{
    public function up()
    {
        $this->createTable('admin_storage_image', [
            'id' => 'pk',
            'file_id' => Schema::TYPE_INTEGER,
            'filter_id' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        echo "m150304_152256_admin_storage_image cannot be reverted.\n";

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
