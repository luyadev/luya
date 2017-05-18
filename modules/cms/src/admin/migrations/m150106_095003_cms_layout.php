<?php


use yii\db\Migration;

class m150106_095003_cms_layout extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_layout', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'json_config' => $this->text(),
            'view_file' => $this->string(255),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_layout');
    }
}
