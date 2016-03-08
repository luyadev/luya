<?php

use yii\db\Schema;
use yii\db\Migration;

class m141104_104631_admin_user_group extends Migration
{
    public function up()
    {
        $this->createTable('admin_user_group', [
            'id' => 'pk',
            'user_id' => Schema::TYPE_INTEGER,
            'group_id' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        echo "m141104_104631_admin_user_group cannot be reverted.\n";

        return false;
    }
}
