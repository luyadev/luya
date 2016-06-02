<?php

use yii\db\Migration;

class m160602_125708_filemanagercaption extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_storage_file', 'caption', 'text');
    }

    public function safeDown()
    {
        $this->dropColumn('admin_storage_file', 'caption');
    }
}
