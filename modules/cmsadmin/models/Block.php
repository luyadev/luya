<?php
namespace cmsadmin\models;

class Block extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cms_block';
    }

    public function rules()
    {
        return [
            [['name', 'json_config', 'twig_frontend', 'twig_admin'], 'required']
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'json_config', 'twig_frontend', 'twig_admin'],
            'restupdate' => ['name', 'json_config', 'twig_frontend', 'twig_admin'],
        ];
    }
}
