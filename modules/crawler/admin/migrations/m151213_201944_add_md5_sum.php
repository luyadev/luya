<?php

use yii\db\Schema;
use yii\db\Migration;

class m151213_201944_add_md5_sum extends Migration
{
    public function up()
    {
        $this->addColumn("crawler_builder_index", "content_hash", "varchar(80)");
        $this->addColumn("crawler_builder_index", "is_dublication", "tinyint(1) default 0");
        $this->dropColumn("crawler_builder_index", "arguments_json");
        $this->dropColumn("crawler_index", "arguments_json");
    }

    public function down()
    {
        echo "m151213_201944_add_md5_sum cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
