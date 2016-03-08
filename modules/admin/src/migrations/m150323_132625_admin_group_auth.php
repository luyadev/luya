<?php

use yii\db\Schema;
use yii\db\Migration;

class m150323_132625_admin_group_auth extends Migration
{
    public function up()
    {
        $this->createTable('admin_group_auth', [
            'group_id' => Schema::TYPE_INTEGER.'(11)',
            'auth_id' => Schema::TYPE_INTEGER.'(11)',
            'crud_create' => Schema::TYPE_SMALLINT.'(4)',
            'crud_update' => Schema::TYPE_SMALLINT.'(4)',
            'crud_delete' => Schema::TYPE_SMALLINT.'(4)',
        ]);
    }

    public function down()
    {
        echo "m150323_132625_admin_group_auth cannot be reverted.\n";

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
