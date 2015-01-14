<?php
namespace cmsadmin\models;

class Layout extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cms_layout';
    }

    public function rules()
    {
        return [
            [["name", "json_config", "view_file"], "required"]
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'json_config', 'view_file'],
            'restupdate' => ['name', 'json_config', 'view_file']
        ];
    }
}
