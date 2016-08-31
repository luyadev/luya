<?php

use yii\db\Migration;

class m151028_085932_add_is_home_in_nav extends Migration
{
    public function up()
    {
        $this->addColumn('cms_nav', 'is_home', 'tinyint(1) default 0');
        $this->dropColumn('cms_cat', 'default_nav_id');
        $this->dropColumn('cms_cat', 'is_default');
    }

    public function down()
    {
        echo "m151028_085932_add_is_home_in_nav cannot be reverted.\n";

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
