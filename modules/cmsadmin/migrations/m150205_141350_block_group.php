<?php

use yii\db\Schema;
use yii\db\Migration;

class m150205_141350_block_group extends Migration
{
    public function up()
    {
        $this->createTable("cms_block_group", [
            "id" => "pk",
            "name" => Schema::TYPE_STRING,
        ]);

        $this->insert("cms_block_group", [
            "id" => 1,
            "name" => "Text Abschnitte",
        ]);

        $this->insert("cms_block_group", [
            "id" => 2,
            "name" => "Desgin Elemente",
        ]);
    }

    public function down()
    {
        echo "m150205_141350_block_cat cannot be reverted.\n";

        return false;
    }
}
