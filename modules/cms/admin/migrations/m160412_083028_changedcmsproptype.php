<?php

use yii\db\Migration;

class m160412_083028_changedcmsproptype extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->alterColumn('cms_nav_property', 'value', 'text');
    }

    public function safeDown()
    {
        $this->alterColumn('cms_nav_property', 'value', 'varchar(255) not null');
    }
}
