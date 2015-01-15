<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_143111_cms_nav_item extends Migration
{
    public function up()
    {
        $this->createTable("cms_nav_item", [
            "id" => "pk",
            "nav_id" => Schema::TYPE_INTEGER,
            "lang_id" => Schema::TYPE_INTEGER,
            "nav_item_type" => Schema::TYPE_SMALLINT,
            "nav_item_type_id" => Schema::TYPE_INTEGER,
            "is_hidden" => Schema::TYPE_SMALLINT,
            "is_inactive" => Schema::TYPE_SMALLINT,
            "create_user_id" => Schema::TYPE_INTEGER,
            "update_user_id" => Schema::TYPE_INTEGER,
            "timestamp_create" => Schema::TYPE_INTEGER,
            "timestamp_update" => Schema::TYPE_INTEGER,
            "title" => Schema::TYPE_STRING,
            "rewrite" => Schema::TYPE_STRING,
        ]);
    }

    public function down()
    {
        echo "m141203_143111_cms_nav_item cannot be reverted.\n";

        return false;
    }
}
