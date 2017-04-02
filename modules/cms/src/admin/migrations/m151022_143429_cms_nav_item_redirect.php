<?php

use yii\db\Migration;

class m151022_143429_cms_nav_item_redirect extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_item_redirect', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(11)->notNull(),
            'value' => $this->string(255)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_item_redirect');
    }
}
