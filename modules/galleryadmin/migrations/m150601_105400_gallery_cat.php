<?php

use yii\db\Schema;
use yii\db\Migration;

class m150601_105400_gallery_cat extends Migration
{
    public function up()
    {
        $this->createTable('gallery_cat', [
            "id" => "pk",
            "title" => "VARCHAR(120) NOT NULL",
        ]);
    }

    public function down()
    {
        echo "m150601_105400_gallery_cat cannot be reverted.\n";

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
