<?php

use yii\db\Schema;
use yii\db\Migration;

class m150304_152250_admin_storage_effect extends Migration
{
    public function up()
    {
        $this->createTable("admin_storage_effect", [
            "id" => "pk",
            "name" => Schema::TYPE_STRING,
            "imagine_name" => Schema::TYPE_STRING,
            "imagine_json_params" => Schema::TYPE_STRING,
        ]);
        
        $this->insert("admin_storage_effect", [
            "name" => "Thumbnail",
            "imagine_name" => "thumbnail",
            "imagine_json_params" => json_encode(['vars' => [
                ['var' => "width", 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]])
        ]);
        
        $this->insert("admin_storage_effect", [
            "name" => "Zuschneiden",
            "imagine_name" => "resize",
            "imagine_json_params" => json_encode(['vars' => [
                ['var' => "width", 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],        
            ]])  
        ]);
        
        $this->insert("admin_storage_effect", [
            "name" => "Crop",
            "imagine_name" => "crop",
            "imagine_json_params" => json_encode(['vars' => [
                ['var' => "width", 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]])
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