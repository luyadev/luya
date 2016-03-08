<?php

use yii\db\Schema;
use yii\db\Migration;

class m150122_125429_cms_nav_item_module extends Migration
{
    public function up()
    {
        $this->createTable('cms_nav_item_module', [
            'id' => 'pk',
            'module_name' => Schema::TYPE_STRING,
        ]);
    }

    public function down()
    {
        echo "m150122_125429_cms_nav_item_module cannot be reverted.\n";

        return false;
    }
}
