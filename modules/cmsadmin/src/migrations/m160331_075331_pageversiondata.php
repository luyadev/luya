<?php

use yii\db\Migration;

class m160331_075331_pageversiondata extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cms_nav_item_page', 'nav_item_id', 'int(11) NOT NULL');
        $this->addColumn('cms_nav_item_page', 'timestamp_create', 'int(11) NOT NULL');
        $this->addColumn('cms_nav_item_page', 'create_user_id', 'int(11) NOT NULL');
        $this->addColumn('cms_nav_item_page', 'version_alias', 'varchar(250)');
    }

    public function safeDown()
    {
        $this->dropColumn('cms_nav_item_page', 'nav_item_id');
        $this->dropColumn('cms_nav_item_page', 'timestamp_create');
        $this->dropColumn('cms_nav_item_page', 'create_user_id');
        $this->dropColumn('cms_nav_item_page', 'version_alias');
    }
}
