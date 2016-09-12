<?php

use yii\db\Migration;

class m150617_200836_admin_user_online extends Migration
{
    public function up()
    {
        $this->createTable('admin_user_online', [
            'id' => 'pk',
            'user_id' => 'int(11) NOT NULL',
            'last_timestamp' => 'int(11) NOT NULL',
            'invoken_route' => 'varchar(120) NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m150617_200836_admin_user_online cannot be reverted.\n";

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
