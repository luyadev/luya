<?php


use yii\db\Migration;

class m150108_155009_cms_nav_item_page_block_item extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_item_page_block_item', [
            'id' => $this->primaryKey(),
            'block_id' => $this->integer(11)->notNull(),
            'placeholder_var' => $this->string(80)->notNull(),
            'nav_item_page_id' => $this->integer(11),
            'prev_id' => $this->integer(11),
            'json_config_values' => $this->text(),
            'json_config_cfg_values' => $this->text(),
            'is_dirty' => $this->boolean()->defaultValue(false),
            'create_user_id' => $this->integer(11)->defaultValue(0),
            'update_user_id' => $this->integer(11)->defaultValue(0),
            'timestamp_create' => $this->integer(11)->defaultValue(0),
            'timestamp_update' => $this->integer(11)->defaultValue(0),
            'sort_index' => $this->integer(11)->defaultValue(0),
            'is_hidden' => $this->boolean()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_item_page_block_item');
    }
}
