<?php

use yii\db\Schema;
use yii\db\Migration;

class m150108_155009_cms_nav_item_page_block_item extends Migration
{
    public function up()
    {
        /**
         * @TODO make a block offline or online (for example if you drop in a block, he should be offline until you have updated it with informations.
         * otherwise the user can see empty blocks in the frontend
         */
        $this->createTable("cms_nav_item_page_block_item", [
            "id" => "pk",
            "block_id" => Schema::TYPE_INTEGER,
            "placeholder_space" => Schema::TYPE_STRING,
            "nav_item_page_id" => Schema::TYPE_INTEGER,
            "prev_id" => Schema::TYPE_INTEGER,
            "json_config_values" => Schema::TYPE_TEXT,
        ]);
    }

    public function down()
    {
        echo "m150108_155009_cms_nav_item_page_block_item cannot be reverted.\n";

        return false;
    }
}
