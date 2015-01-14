<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_121042_admin_lang extends Migration
{
    public function up()
    {
        $this->createTable("admin_lang", [
            "id" => "pk",
            "name" => Schema::TYPE_STRING,
            "short_code" => Schema::TYPE_STRING,
            "is_default" => Schema::TYPE_SMALLINT
        ]);

        $this->insert("admin_lang", [
            "name" => "Deutsch",
            "short_code" => "de",
            "is_default" => 1
        ]);
    }

    public function down()
    {
        echo "m141203_121042_admin_lang cannot be reverted.\n";

        return false;
    }
}
