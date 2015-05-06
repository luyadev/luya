<?php

use yii\db\Migration;

class m150331_125022_admin_ngrest_log extends Migration
{
    public function up()
    {
        $this->createTable('admin_ngrest_log', [
            'id' => 'pk',
            'user_id' => 'int(11) NOT NULL',
            'timestamp_create' => 'int(11) NOT NULL',
            'route' => 'VARCHAR(80) NOT NULL',
            'api' => 'VARCHAR(80) NOT NULL',
            'is_update' => 'tinyint(1) default 0',
            'is_insert' => 'tinyint(1) default 0',
            'attributes_json' => 'TEXT NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m150331_125022_admin_ngrest_log cannot be reverted.\n";

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
