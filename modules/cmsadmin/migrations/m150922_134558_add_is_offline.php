<?php

use yii\db\Migration;

/**
 * @todo next version remove and replace inside the base tabl cms_nav (add column to base table)
 *
 * @author nadar
 */
class m150922_134558_add_is_offline extends Migration
{
    public function up()
    {
        $this->addColumn('cms_nav', 'is_offline', 'TINYINT(1) DEFAULT 0');
    }

    public function down()
    {
        echo "m150922_134558_add_is_offline cannot be reverted.\n";

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
