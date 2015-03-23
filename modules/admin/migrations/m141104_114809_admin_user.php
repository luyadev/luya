<?php

use yii\db\Schema;
use yii\db\Migration;

class m141104_114809_admin_user extends Migration
{
    public function up()
    {
        $this->createTable("admin_user", [
            "id" => "pk",
            "firstname" => Schema::TYPE_STRING,
            "lastname" => Schema::TYPE_STRING,
            "title" => Schema::TYPE_SMALLINT,
            "email" => Schema::TYPE_STRING,
            "password" => Schema::TYPE_STRING,
            "password_salt" => Schema::TYPE_STRING,
            "auth_token" => Schema::TYPE_STRING,
            "is_deleted" => Schema::TYPE_SMALLINT,
        ]);

        $salt = \Yii::$app->getSecurity()->generateRandomString();
        $password = \Yii::$app->getSecurity()->generatePasswordHash("defaultPassword".$salt);

        $this->insert("admin_user", [
            "firstname" => "Zephir",
            "lastname" => "Software Design AG",
            "email" => "info@zephir.ch",
            "password" => $password,
            "password_salt" => $salt,
            "is_deleted" => 0,
        ]);
    }

    public function down()
    {
        echo "m141104_114809_admin_user cannot be reverted.\n";

        return false;
    }
}
