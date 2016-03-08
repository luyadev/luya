<?php

use yii\db\Migration;

class m141203_143059_cms_nav extends Migration
{
    public function up()
    {
        $this->createTable('cms_nav', [
            'id' => 'pk',
            'cat_id' => 'int(11) NOT NULL DEFAULT 0', // renamed to nav_container_id
            'parent_nav_id' => 'int(11) NOT NULL DEFAULT 0',
            'sort_index' => 'int(11) NOT NULL DEFAULT 0',
            'is_deleted' => 'tinyint(1) DEFAULT 0',
            'is_hidden' => 'tinyint(1) DEFAULT 0',
        ]);
    }

    public function down()
    {
        echo "m141203_143059_cms_nav cannot be reverted.\n";

        return false;
    }
}
