<?php


use yii\db\Migration;

class m141203_143111_cms_nav_item extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_item', [
            'id' => $this->primaryKey(),
            'nav_id' => $this->integer(11)->notNull(),
            'lang_id' => $this->integer(11)->notNull(),
            'nav_item_type' => $this->integer(11)->notNull(),
            'nav_item_type_id' => $this->integer(11)->notNull(),
            'create_user_id' => $this->integer(11)->notNull(),
            'update_user_id' => $this->integer(11)->notNull(),
            'timestamp_create' => $this->integer(11)->defaultValue(0),
            'timestamp_update' => $this->integer(11)->defaultValue(0),
            'title' => $this->string(180)->notNull(),
            'alias' => $this->string(80)->notNull(),
            'description' => $this->text(),
            'keywords' => $this->text(),
            'title_tag' => $this->string(255),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_item');
    }
}
