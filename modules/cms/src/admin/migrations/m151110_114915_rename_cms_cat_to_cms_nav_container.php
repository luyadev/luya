<?php

use yii\db\Schema;
use yii\db\Migration;

class m151110_114915_rename_cms_cat_to_cms_nav_container extends Migration
{
    public function up()
    {
        $this->renameTable("cms_cat", "cms_nav_container");
        $this->renameColumn("cms_nav", "cat_id", "nav_container_id");
    }

    public function down()
    {
        echo "m151110_114915_rename_cms_cat_to_cms_nav_container cannot be reverted.\n";

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
