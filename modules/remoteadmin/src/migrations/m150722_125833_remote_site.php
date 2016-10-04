<?php

use yii\db\Schema;
use yii\db\Migration;

class m150722_125833_remote_site extends Migration
{
    public function up()
    {
        $this->createTable('remote_site', [
            'id' => 'pk',
            'token' => 'varchar(120)',
            'url' => 'varchar(120)',
            'status' => 'int(11)',
        ]);
    }

    public function down()
    {
        echo "m150722_125833_remote_site cannot be reverted.\n";

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
