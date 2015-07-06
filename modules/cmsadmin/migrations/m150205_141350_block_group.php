<?php

use yii\db\Schema;
use yii\db\Migration;

class m150205_141350_block_group extends Migration
{
    public function up()
    {
        $this->createTable('cms_block_group', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING,
            'is_deleted' => 'TINYINT(1) NOT NULL default 0',
        ]);

        $this->insert('cms_block_group', [
            'id' => 1,
            'name' => 'Inhalts-Elemente',
        ]);

        $this->insert('cms_block_group', [
            'id' => 2,
            'name' => 'Layout-Elemente',
        ]);
        
        $this->insert('cms_block_group', [
            'id' => 3,
            'name' => 'Modul-Elemente',
        ]);
        
        $this->insert('cms_block_group', [
            'id' => 4,
            'name' => 'Projekt-Elemente',
        ]);
        
        $this->insert('cms_block_group', [
            'id' => 5,
            'name' => 'Entwicklung',
        ]);
    }

    public function down()
    {
        echo "m150205_141350_block_cat cannot be reverted.\n";

        return false;
    }
}
