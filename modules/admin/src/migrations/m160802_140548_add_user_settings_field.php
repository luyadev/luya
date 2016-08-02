<?php

use yii\db\Migration;

class m160802_140548_add_user_settings_field extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('admin_user', 'settings', 'text');
        $this->addColumn('admin_storage_file', 'internal_note', 'text');
    }

    public function safeDown()
    {
        $this->dropColumn('admin_user', 'settings');
        $this->dropColumn('admin_storage_file', 'internal_note');
    }
}
