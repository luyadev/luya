<?php

use yii\db\Migration;

class m151022_143429_cms_nav_item_redirect extends Migration
{
    public function up()
    {
        $this->createTable('cms_nav_item_redirect', [
            'id' => 'pk',
            'type' => 'int(11) NOT NULL',
            'value' => 'varchar(255) NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m151022_143429_cms_nav_item_redirect cannot be reverted.\n";

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
