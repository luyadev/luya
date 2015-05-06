<?php

use yii\db\Schema;
use yii\db\Migration;

class m150106_095003_cms_layout extends Migration
{
    public function up()
    {
        $this->createTable('cms_layout', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING,
            'json_config' => Schema::TYPE_TEXT,
            'view_file' => Schema::TYPE_STRING,
        ]);
    }

    public function down()
    {
        echo "m150106_095003_cms_layout cannot be reverted.\n";

        return false;
    }
}
