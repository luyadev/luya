<?php

use yii\db\Migration;

class m170301_084325_cms_config extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('cms_config', [
            'name' => $this->string(80),
            'value' => $this->string(255)->notNull(),
            'PRIMARY KEY(name)',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_config');
    }
}
