<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_143052_cms_cat extends Migration
{
    public function up()
    {
        $this->createTable("cms_cat", [
            "id" => "pk",
            "name" => "VARCHAR(180) NOT NULL",
            "rewrite" => "VARCHAR(80) NOT NULL",
            "default_nav_id" => "INT(11) NOT NULL",
            "is_default" => "TINYINT(1) NOT NULL DEFAULT 0",
        ]);
    }

    public function down()
    {
        echo "m141203_143052_cms_cat cannot be reverted.\n";

        return false;
    }
}
