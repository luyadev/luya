<?php

use yii\db\Migration;

class m151020_065710_user_force_reload extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_user', 'force_reload', $this->boolean()->defaultValue(0));
    }

    public function safeDown()
    {
    	$this->dropColumn('admin_user', 'force_reload');
    }
}
