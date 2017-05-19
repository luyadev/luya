<?php


use yii\db\Migration;

class m150304_152256_admin_storage_image extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_storage_image', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer(11),
            'filter_id' => $this->integer(11),
            'resolution_width' => $this->integer(11),
            'resolution_height' => $this->integer(11),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_storage_image');
    }
}
