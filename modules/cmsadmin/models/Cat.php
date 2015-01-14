<?php
namespace cmsadmin\models;

class Cat extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cms_cat';
    }

    public function rules()
    {
        return [
            [['name', 'rewrite', 'default_nav_id'], 'required']
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'rewrite', 'default_nav_id'],
            'restupdate' => ['name', 'rewrite', 'default_nav_id']
        ];
    }
}
