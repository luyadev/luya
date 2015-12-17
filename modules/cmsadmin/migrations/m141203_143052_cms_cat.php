<?php

use yii\db\Migration;

class m141203_143052_cms_cat extends Migration
{
    public function up()
    {
        $this->createTable('cms_cat', [ // renameed to cms_nav_container
            'id' => 'pk',
            'name' => 'VARCHAR(180) NOT NULL',
            'rewrite' => 'VARCHAR(80) NOT NULL', // renamed to alias
            'default_nav_id' => 'INT(11) NOT NULL', // dropped in m151028_085932_add_is_home_in_nav
            'is_default' => 'TINYINT(1) NOT NULL DEFAULT 0', // dropped in m151028_085932_add_is_home_in_nav
            'is_deleted' => 'TINYINT(1) NOT NULL default 0',
        ]);

        $this->insert('cms_cat', [ // renamed to cms_nav_container
            'name' => 'Default Container',
            'rewrite' => 'default', // renmaed to alias
            'default_nav_id' => 1,
            'is_default' => 1,
        ]);
    }

    public function down()
    {
        echo "m141203_143052_cms_cat cannot be reverted.\n";

        return false;
    }
}
