<?php

use yii\db\Schema;
use yii\db\Migration;

class m150304_152250_admin_storage_effect extends Migration
{
    public function up()
    {
        $this->createTable('admin_storage_effect', [
            'id' => 'pk',
            'identifier' => 'VARCHAR(100) NOT NULL UNIQUE',
            'name' => Schema::TYPE_STRING,
            'imagine_name' => Schema::TYPE_STRING,
            'imagine_json_params' => Schema::TYPE_STRING,
        ]);
    }

    public function down()
    {
        echo "m150304_152250_admin_storage_effect cannot be reverted.\n";

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

/*
EffectId: 1 = resize (x/y);
EffectId: 2 = cropTo (x/y);
EffectId: 3 = blackwhite()

Filter:
ID 1 = ProfilBild

FilterChain: [
    1 => "Effect1" => params(45/45),
    3 => "Effect3" => false;
]

*/
