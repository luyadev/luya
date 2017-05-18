<?php


use yii\db\Migration;

class m141203_121042_admin_lang extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_lang', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'short_code' => $this->string(15),
            'is_default' => $this->boolean()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_lang');
    }
}
