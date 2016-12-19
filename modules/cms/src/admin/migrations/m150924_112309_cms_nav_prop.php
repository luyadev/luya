<?php

use yii\db\Migration;

class m150924_112309_cms_nav_prop extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_property', [
            'id' => $this->primaryKey(),
            'nav_id' => $this->integer(11)->notNull(),
            'admin_prop_id' => $this->integer(11)->notNull(),
            'value' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_property');
    }
}
