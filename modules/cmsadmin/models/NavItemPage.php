<?php
namespace cmsadmin\models;

class NavItemPage extends \cmsadmin\base\NavItemType
{
    public static function tableName()
    {
        return 'cms_nav_item_page';
    }

    public function rules()
    {
        return [
            [['layout_id'], 'required'],
            [['text'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['layout_id'],
            'restupdate' => ['layout_id']
        ];
    }

    public function getContent()
    {
        return $this->text;
    }

    public function getHeaders()
    {
        return 'HEADERS!';
    }
}
