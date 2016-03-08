<?php

use yii\db\Migration;

class m151026_161841_admin_tag extends Migration
{
    public function up()
    {
        $this->createTable('admin_tag', [
            'id' => 'pk',
            'name' => 'varchar(120) NOT NULL UNIQUE',
        ]);

        $this->createTable('admin_tag_relation', [
            'tag_id' => 'int(11) NOT NULL',
            'table_name' => 'varchar(120) NOT NULL',
            'pk_id' => 'int(11) NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m151026_161841_admin_tag cannot be reverted.\n";

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
