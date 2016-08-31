<?php

use yii\db\Schema;
use yii\db\Migration;

class m151110_113803_rename_rewrite_to_alias extends Migration
{
    public function up()
    {
        $this->renameColumn("cms_nav_item", "rewrite", "alias");
        $this->renameColumn("cms_cat", "rewrite", "alias");
    }

    public function down()
    {
        echo "m151110_113803_rename_rewrite_to_alias cannot be reverted.\n";

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
