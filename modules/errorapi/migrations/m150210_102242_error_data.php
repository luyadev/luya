<?php

use yii\db\Schema;
use yii\db\Migration;

class m150210_102242_error_data extends Migration
{
    public function up()
    {
        $this->createTable('error_data', [
            "id" => "pk",
            "identifier" => Schema::TYPE_STRING,
            "error_json" => Schema::TYPE_TEXT, 
            "timestamp_create" => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        echo "m150210_102242_error_data cannot be reverted.\n";

        return false;
    }
}
