<?php

use yii\db\Schema;
use yii\db\Migration;

class m150108_154017_cms_block extends Migration
{
    public function up()
    {
        $this->createTable("cms_block", [
            "id" => "pk",
            "group_id" => Schema::TYPE_INTEGER,
            "system_block" => Schema::TYPE_INTEGER,
            "class" => Schema::TYPE_STRING,
        ]);

        /*
        $this->insert("cms_block", [
            "group_id" => 1,
            "system_block" => 1,
            "class" => "\cmsadmin\blocks\Heading1Block",
        ]);

        $this->insert("cms_block", [
            "group_id" => 1,
            "system_block" => 1,
            "class" => "\cmsadmin\blocks\Heading2Block",
        ]);

        $this->insert("cms_block", [
            "group_id" => 1,
            "system_block" => 1,
            "class" => "\cmsadmin\blocks\ParagraphBlock",
        ]);

        $this->insert("cms_block", [
            "group_id" => 2,
            "system_block" => 1,
            "class" => "\cmsadmin\blocks\ImageBlock",
        ]);
        */
    }

    public function down()
    {
        echo "m150108_154017_cms_block cannot be reverted.\n";

        return false;
    }
}
