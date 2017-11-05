<?php

use yii\db\Migration;

class m170926_164913_add_ngrest_log_diff_data extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_ngrest_log', 'attributes_diff_json', $this->text()->null());
        $this->addColumn('admin_ngrest_log', 'pk_value', $this->string());
        $this->addColumn('admin_ngrest_log', 'table_name', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('admin_ngrest_log', 'attributes_diff_json', $this->text());
        $this->dropColumn('admin_ngrest_log', 'pk_value', $this->string());
        $this->dropColumn('admin_ngrest_log', 'table_name', $this->string());
    }
}
