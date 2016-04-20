<?php

namespace cmsadmin\models;

/**
 * Represents the Block-Group Model where blocks can be stored inside.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class BlockGroup extends \admin\ngrest\base\Model
{
    use \admin\traits\SoftDeleteTrait;

    public function ngRestApiEndpoint()
    {
        return 'api-cms-blockgroup';
    }

    public static function tableName()
    {
        return 'cms_block_group';
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'identifer' => 'Identifier',
        ];
    }
    
    public function ngrestAttributeTypes()
    {
        return [
            'name' => 'text',
            'identifier' => 'text',
        ];
    }
    
    public function ngRestConfig($config)
    {
        $config->delete = true;
        
        $this->ngRestConfigDefine($config, ['list', 'create', 'update'], ['name', 'identifier']);
        
        return $config;
    }

    public function rules()
    {
        return [
            [['name', 'identifier'], 'required'],
            ['identifier', 'unique'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'identifier'],
            'restupdate' => ['name', 'identifier'],
        ];
    }
}
