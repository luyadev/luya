<?php

use yii\db\Migration;

class m161219_150240_admin_lang_soft_delete extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_lang', 'is_deleted', $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('admin_lang', 'is_deleted');
    }
}
