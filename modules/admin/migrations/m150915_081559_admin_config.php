<?php

use yii\db\Migration;

class m150915_081559_admin_config extends Migration
{
    public function up()
    {
        $this->createTable('admin_config', [
            'name' => 'VARCHAR(80) NOT NULL UNIQUE PRIMARY KEY',
            'value' => 'VARCHAR(255) NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m150915_081559_admin_config cannot be reverted.\n";

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
