<?php

use yii\db\Migration;

class m161230_173046_issue1125 extends Migration
{
    public function up()
    {
		$this->createTable('ngresttest_order', [
			'id' => $this->primaryKey(),
			'customer_id' => $this->integer(11),
			'title' => $this->string(),
		]);
		
		$this->createTable('ngresttest_customer', [
			'id' => $this->primaryKey(),
			'name' => $this->string(),
			'phone' => $this->string(),
			'address' => $this->string(),
		]);
    }

    public function down()
    {
        echo "m161230_173046_issue1125 cannot be reverted.\n";

        return false;
    }
}
