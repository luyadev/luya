<?php

namespace cmsadmin\models;

class Property extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cms_nav_property';
    }

    public function rules()
    {
        return [
            [['nav_id', 'admin_prop_id', 'value'], 'required'],
        ];
    }
}
