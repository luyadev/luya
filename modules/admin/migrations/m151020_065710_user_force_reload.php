<?php

use yii\db\Migration;

class m151020_065710_user_force_reload extends Migration
{
    public function up()
    {
        $this->addColumn('admin_user', 'force_reload', 'tinyint(1) default 0');
    }

    public function down()
    {
        echo "m151020_065710_user_force_reload cannot be reverted.\n";

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
