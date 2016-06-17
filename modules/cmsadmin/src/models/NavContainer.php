<?php

namespace cmsadmin\models;

use admin\models\Lang;

/**
 * Represents the Navigation-Containers.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class NavContainer extends \admin\ngrest\base\Model
{
    use \admin\traits\SoftDeleteTrait;

    public static function ngRestApiEndpoint()
    {
        return 'api-cms-navcontainer';
    }

    private $_langId = null;

    public function getLangId()
    {
        if ($this->_langId === null) {
            $array = Lang::getDefault();
            $this->_langId = $array['id'];
        }

        return $this->_langId;
    }

    private function getNavData()
    {
        $_data = [];
        foreach (Nav::find()->all() as $item) {
            $x = $item->getNavItems()->where(['lang_id' => $this->getLangId()])->asArray()->one();
            if ($x) {
                $_data[$x['nav_id']] = $x['title'];
            }
        }

        return $_data;
    }

    public function ngRestConfig($config)
    {
        $config->delete = true;

        $config->list->field('name', 'Name')->text();
        $config->list->field('alias', 'Alias')->text();

        $config->create->copyFrom('list');
        $config->update->copyFrom('list');

        return $config;
    }

    public static function tableName()
    {
        return 'cms_nav_container';
    }

    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'alias'],
            'restupdate' => ['name', 'alias'],
        ];
    }

    private static $_queryInstance = null;

    public static function getQuery()
    {
        if (self::$_queryInstance === null) {
            self::$_queryInstance = self::find()->asArray()->indexBy('id')->all();
        }

        return self::$_queryInstance;
    }
}
