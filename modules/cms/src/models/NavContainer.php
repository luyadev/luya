<?php

namespace luya\cms\models;

use luya\admin\traits\SoftDeleteTrait;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Represents the Navigation-Containers.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class NavContainer extends NgRestModel
{
    use SoftDeleteTrait;

    public static function tableName()
    {
        return 'cms_nav_container';
    }
    
    public static function ngRestApiEndpoint()
    {
        return 'api-cms-navcontainer';
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
    
    public function ngRestConfig($config)
    {
        $config->delete = true;

        $config->list->field('name', 'Name')->text();
        $config->list->field('alias', 'Alias')->text();

        $config->create->copyFrom('list');
        $config->update->copyFrom('list');

        $config->options = [
            'saveCallback' => 'function(ServiceMenuData) { ServiceMenuData.load(true); }',
        ];
        
        return $config;
    }
    
    /**
     * Relation returns all `cms_nav` rows belongs to this container sort by index without deleted or draf items.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNavs()
    {
        return $this->hasMany(Nav::className(), ['nav_container_id' => 'id'])->where(['is_deleted' => false, 'is_draft' => false])->orderBy(['sort_index' => SORT_ASC]);
    }
}
