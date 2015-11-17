<?php

use yii\db\Schema;
use yii\db\Migration;

class m151116_105124_image_resolution_to_storage_image extends Migration
{
    public function up()
    {
        $this->addColumn('admin_storage_image', 'resolution_width', 'int(11)');
        $this->addColumn('admin_storage_image', 'resolution_height', 'int(11)');
    }

    public function down()
    {
        echo "m151116_105124_image_resolution_to_storage_image cannot be reverted.\n";

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
