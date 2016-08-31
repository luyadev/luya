<?php

use yii\db\Migration;

class m150428_095829_news_cat extends Migration
{
    public function up()
    {
        $this->createTable('news_cat', [
            'id' => 'pk',
            'title' => 'VARCHAR(150) NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m150428_095829_news_cat cannot be reverted.\n";

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
