<?php


use yii\db\Migration;

class m141104_114809_admin_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_user', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(255),
            'lastname' => $this->string(255),
            'title' => $this->smallInteger(1),
            'email' => $this->string(120)->notNull()->unique(),
            'password' => $this->string(255),
            'password_salt' => $this->string(255),
            'auth_token' => $this->string(255),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'secure_token' => $this->string(40),
            'secure_token_timestamp' => $this->integer(11)->defaultValue(0),
            'force_reload' => $this->boolean()->defaultValue(false),
            'settings' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_user');
    }
}
