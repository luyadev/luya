<?php

namespace luyatests\data\models;

use yii\db\ActiveRecord;

class AdminAuthModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'admin_auth';
    }
}
