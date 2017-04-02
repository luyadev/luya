<?php

use yii\db\Migration;

class m170131_104109_user_model_updates extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_user', 'cookie_token', $this->string());
        $this->addColumn('admin_user_online', 'lock_pk', $this->string());
        $this->addColumn('admin_user_online', 'lock_table', $this->string());
        $this->addColumn('admin_user_online', 'lock_translation', $this->string());
        $this->addColumn('admin_user_online', 'lock_translation_args', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('admin_user', 'cookie_token');
        $this->dropColumn('admin_user_online', 'lock_pk');
        $this->dropColumn('admin_user_online', 'lock_table');
        $this->dropColumn('admin_user_online', 'lock_translation');
        $this->dropColumn('admin_user_online', 'lock_translation_args');
    }
}
