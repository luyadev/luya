<?php

use yii\db\Migration;

class m150924_120914_admin_prop extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_property', [
            'id' => $this->primaryKey(),
            'module_name' => $this->string(120),
            'var_name' => $this->string(40)->notNull()->unique(),
            'class_name' => $this->string(200)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_property');
    }
}
