<?php


use yii\db\Migration;

class m150210_102242_error_data extends Migration
{
    public function safeUp()
    {
        $this->createTable('error_data', [
            'id' => $this->primaryKey(),
            'identifier' => $this->string(255),
            'error_json' => $this->text(),
            'timestamp_create' => $this->integer(11)->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('error_data');
    }
}
