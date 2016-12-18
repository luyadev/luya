<?php

use yii\db\Migration;

class m151007_084953_storage_folder_is_deleted extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_storage_folder', 'is_deleted', $this->boolean()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('admin_storage_folder', 'is_deleted');
    }
}
