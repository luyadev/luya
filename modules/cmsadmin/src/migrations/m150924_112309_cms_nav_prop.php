<?php

use yii\db\Migration;

class m150924_112309_cms_nav_prop extends Migration
{
    public function up()
    {
        $this->createTable('cms_nav_property', [
            'id' => 'pk',
            'nav_id' => 'int(11) not null',
            'admin_prop_id' => 'int(11) not null',
            'value' => 'varchar(255) not null',
        ]);
    }

    public function down()
    {
        echo "m150924_112309_cms_nav_prop cannot be reverted.\n";

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
