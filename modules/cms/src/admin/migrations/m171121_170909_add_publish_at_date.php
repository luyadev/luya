<?php

use yii\db\Migration;

class m171121_170909_add_publish_at_date extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cms_nav', 'publish_from', $this->integer()->null());
        $this->addColumn('cms_nav', 'publish_till', $this->integer()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('cms_nav', 'publish_from');
        $this->dropColumn('cms_nav', 'publish_till');
    }
}
