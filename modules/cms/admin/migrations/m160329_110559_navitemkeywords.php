<?php

use yii\db\Migration;

class m160329_110559_navitemkeywords extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cms_nav_item', 'keywords', 'text');
    }

    public function safeDown()
    {
        $this->dropColumn('cms_nav_item', 'keywords');
    }
}
