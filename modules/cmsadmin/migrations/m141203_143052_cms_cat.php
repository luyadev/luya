<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_143052_cms_cat extends Migration
{
    public function up()
    {
        $this->createTable("cms_cat", [
            "id" => "pk",
            "name" => Schema::TYPE_STRING,
            "rewrite" => Schema::TYPE_STRING,
            "default_nav_id" => Schema::TYPE_INTEGER,
            "is_default" => Schema::TYPE_SMALLINT,
        ]);

        $this->insert("cms_cat", [
            "name" => "Default Kategorie",
            "rewrite" => "default",
            "default_nav_id" => 1,
            "is_default" => 1,
        ]);
    }

    public function down()
    {
        echo "m141203_143052_cms_cat cannot be reverted.\n";

        return false;
    }
}
