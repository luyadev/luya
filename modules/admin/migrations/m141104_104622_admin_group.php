<?php

use yii\db\Schema;
use yii\db\Migration;

class m141104_104622_admin_group extends Migration
{
    public function up()
    {
        $this->createTable('admin_group', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING.' NOT NULL',
            'text' => Schema::TYPE_TEXT,
            'is_deleted' => 'TINYINT(1) NOT NULL default 0',
        ]);
    }

    public function down()
    {
        echo "m141104_104622_admin_group cannot be reverted.\n";

        return false;
    }
}
