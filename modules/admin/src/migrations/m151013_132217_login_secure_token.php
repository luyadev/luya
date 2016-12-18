<?php

use yii\db\Migration;

class m151013_132217_login_secure_token extends Migration
{
    public function up()
    {
        $this->addColumn('admin_user', 'secure_token', $this->string(40));
        $this->addColumn('admin_user', 'secure_token_timestamp', $this->integer(11)->defaultValue(0));
    }

    public function down()
    {
    	$this->dropColumn('admin_user', 'secure_token');
    	$this->dropColumn('admin_user', 'secure_token_timestamp');
    }
}
