<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_143059_cms_nav extends Migration
{
    public function up()
    {
        $this->createTable("cms_nav", [
            "id" => "pk",
            "cat_id" => Schema::TYPE_INTEGER,
            "parent_nav_id" => Schema::TYPE_INTEGER,
            "sort_index" => Schema::TYPE_INTEGER,
            "is_deleted" => Schema::TYPE_SMALLINT
        ]);

        $this->insert("cms_nav", [
            "cat_id" => 1,
            "parent_nav_id" => 0,
            "sort_index" => 0,
            "is_deleted" => 0
        ]);
    }

    public function down()
    {
        echo "m141203_143059_cms_nav cannot be reverted.\n";

        return false;
    }
}
