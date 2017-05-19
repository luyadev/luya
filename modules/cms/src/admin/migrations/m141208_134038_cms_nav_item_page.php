<?php


use yii\db\Migration;

class m141208_134038_cms_nav_item_page extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_item_page', [
            'id' => $this->primaryKey(),
            'layout_id' => $this->integer(11)->notNull(),
            'nav_item_id' => $this->integer(11)->notNull(),
            'timestamp_create' => $this->integer(11)->notNull(),
            'create_user_id' => $this->integer(11)->notNull(),
            'version_alias' => $this->string(250),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_item_page');
    }
}
