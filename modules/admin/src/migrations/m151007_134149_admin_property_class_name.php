<?php

use yii\db\Migration;

class m151007_134149_admin_property_class_name extends Migration
{
    public function up()
    {
        $this->addColumn('admin_property', 'class_name', 'varchar(200) NOT NULL');
    }

    public function down()
    {
        echo "m151007_134149_admin_property_class_name cannot be reverted.\n";

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
