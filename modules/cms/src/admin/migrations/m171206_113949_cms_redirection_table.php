<?php

use yii\db\Migration;

/**
 * Class m171206_113949_cms_redirection_type
 */
class m171206_113949_cms_redirection_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('cms_redirect', [
            'id' => $this->primaryKey(),
            'timestamp_create' => $this->integer(),
            'catch_path' => $this->string()->notNull(),
            'redirect_path' => $this->string()->notNull(),
            'redirect_status_code' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('cms_redirect');
    }
}
