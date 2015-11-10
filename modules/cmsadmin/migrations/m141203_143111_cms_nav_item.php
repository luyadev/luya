<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_143111_cms_nav_item extends Migration
{
    public function up()
    {
        $this->createTable('cms_nav_item', [
            'id' => 'pk',
            'nav_id' => 'INT(11) NOT NULL',
            'lang_id' => 'INT(11) NOT NULL',
            'nav_item_type' => 'INT(11) NOT NULL',
            'nav_item_type_id' => 'INT(11) NOT NULL',
            //"is_inactive" => Schema::TYPE_SMALLINT,
            'create_user_id' => 'INT(11) NOT NULL',
            'update_user_id' => 'INT(11) NOT NULL',
            'timestamp_create' => 'INT(11) NULL',
            'timestamp_update' => 'INT(11) NULL',
            'title' => 'VARCHAR(180) NOT NULL',
            'rewrite' => 'VARCHAR(80) NOT NULL', // renamed to alias
        ]);
    }

    public function down()
    {
        echo "m141203_143111_cms_nav_item cannot be reverted.\n";

        return false;
    }
}
