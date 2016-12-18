<?php

use yii\db\Migration;

class m151007_134149_admin_property_class_name extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_property', 'class_name', $this->string(200)->notNull());
    }

    public function safeDown()
    {
    	$this->dropColumn('admin_property', 'class_name');
    }
}
