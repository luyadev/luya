<?php

use yii\db\Schema;
use yii\db\Migration;

class m150924_120914_admin_prop extends Migration
{
    public function up()
    {
        $this->createTable('admin_property', [
            'id' => 'pk',
            'module_name' => 'varchar(120)',
            'var_name' => 'varchar(80) not null UNIQUE',
            'type' => 'varchar(40) not null',
            'label' => 'varchar(120) not null',
            'option_json' => 'varchar(255)',
            'default_value' => 'varchar(255)',
        ]);
    }

    public function down()
    {
        echo "m150924_120914_admin_prop cannot be reverted.\n";

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
