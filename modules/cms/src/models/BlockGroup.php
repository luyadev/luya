<?php

namespace luya\cms\models;

use luya\admin\traits\SoftDeleteTrait;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Represents the Block-Group Model where blocks can be stored inside.
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_deleted
 * @property string $identifier
 * @property integer $created_timestamp
 * @property string $class
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class BlockGroup extends NgRestModel
{
    use SoftDeleteTrait;

    public static function ngRestApiEndpoint()
    {
        return 'api-cms-blockgroup';
    }

    public static function tableName()
    {
        return 'cms_block_group';
    }
    
    public function rules()
    {
    	return [
    		[['name', 'identifier', 'class'], 'required'],
    		[['name', 'identifier', 'class'], 'string'],
    		[['created_timestamp', 'is_deleted'], 'integer'],
    		['identifier', 'unique'],
    	];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'identifer' => 'Identifier',
        	'class' => 'Class Name',
        	'created_timestamp' => 'Created at',
        	'is_deleted' => 'Is deleted',
        ];
    }
    
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'identifier' => 'text',
        	'class' => 'text',
        	'created_timestamp' => 'datetime'
        ];
    }
    
    public function ngRestScopes()
    {
    	return [
    		[['list'], ['name', 'identifier', 'created_timestamp', 'class']],
    	];
    }    
}
