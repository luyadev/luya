<?php

use yii\db\Schema;
use yii\db\Migration;

class m150108_154017_cms_block extends Migration
{
    public function up()
    {
        $this->createTable('cms_block', [
            'id' => 'pk',
            'group_id' => Schema::TYPE_INTEGER,
            'system_block' => Schema::TYPE_INTEGER,
            'class' => Schema::TYPE_STRING,
        ]);
    }

    public function down()
    {
        echo "m150108_154017_cms_block cannot be reverted.\n";

        return false;
    }
}
