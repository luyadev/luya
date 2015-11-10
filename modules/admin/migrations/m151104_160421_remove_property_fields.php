<?php

use yii\db\Migration;

class m151104_160421_remove_property_fields extends Migration
{
    public function up()
    {
        $this->dropColumn('admin_property', 'type');
        $this->dropColumn('admin_property', 'label');
        $this->dropColumn('admin_property', 'option_json');
        $this->dropColumn('admin_property', 'default_value');
    }

    public function down()
    {
        echo "m151104_160421_remove_property_fields cannot be reverted.\n";

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
