<?php

use yii\db\Migration;

class m141203_143052_cms_cat extends Migration
{
    public function up()
    {
        $this->createTable('cms_cat', [
            'id' => 'pk',
            'name' => 'VARCHAR(180) NOT NULL',
            'rewrite' => 'VARCHAR(80) NOT NULL',
            'default_nav_id' => 'INT(11) NOT NULL',
            'is_default' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'is_deleted' => 'TINYINT(1) NOT NULL default 0',
        ]);

        $this->insert('cms_cat', [
            'name' => 'Hauptnavigation',
            'rewrite' => 'default',
            'default_nav_id' => 1,
            'is_default' => 1,
        ]);
    }

    public function down()
    {
        echo "m141203_143052_cms_cat cannot be reverted.\n";

        return false;
    }
}
