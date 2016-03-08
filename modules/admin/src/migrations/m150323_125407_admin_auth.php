<?php

use yii\db\Schema;
use yii\db\Migration;

class m150323_125407_admin_auth extends Migration
{
    public function up()
    {
        $this->createTable('admin_auth', [
            'id' => 'pk',
            'alias_name' => Schema::TYPE_STRING.'(60) NOT NULL',
            'module_name' => Schema::TYPE_STRING.'(60) NOT NULL',
            'is_crud' => Schema::TYPE_SMALLINT.'(1) default 0',
            'route' => Schema::TYPE_STRING.'(200)',
            'api' => Schema::TYPE_STRING.'(80)',
        ]);
    }

    public function down()
    {
        echo "m150323_125407_admin_auth cannot be reverted.\n";

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
