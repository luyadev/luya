<?php


use yii\db\Migration;

class m150304_152250_admin_storage_effect extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_storage_effect', [
            'id' => $this->primaryKey(),
            'identifier' => $this->string(100)->notNull()->unique(),
            'name' => $this->string(255),
            'imagine_name' => $this->string(255),
            'imagine_json_params' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_storage_effect');
    }
}
