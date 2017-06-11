<?php


use yii\db\Migration;

class m150309_142652_admin_storage_filter_chain extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_storage_filter_chain', [
            'id' => $this->primaryKey(),
            'sort_index' => $this->integer(11),
            'filter_id' => $this->integer(11),
            'effect_id' => $this->integer(11),
            'effect_json_values' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_storage_filter_chain');
    }
}
