<?php

use yii\db\Schema;
use yii\db\Migration;

class m150309_142652_admin_storage_filter_chain extends Migration
{
    public function up()
    {
        $this->createTable('admin_storage_filter_chain', [
            'id' => 'pk',
            'sort_index' => Schema::TYPE_INTEGER,
            'filter_id' => Schema::TYPE_INTEGER,
            'effect_id' => Schema::TYPE_INTEGER,
            'effect_json_values' => Schema::TYPE_TEXT,
        ]);
    }

    public function down()
    {
        echo "m150309_142652_admin_storage_filter_chain cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
