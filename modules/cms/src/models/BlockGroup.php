<?php

namespace luya\cms\models;

use Yii;
use luya\admin\traits\SoftDeleteTrait;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Represents a group of blocks.
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_deleted
 * @property string $identifier
 * @property integer $created_timestamp
 * @property string $class
 * @property \luya\cms\base\BlockGroup $classObject returns the class object based on the current Active Record.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class BlockGroup extends NgRestModel
{
    use SoftDeleteTrait;

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-cms-blockgroup';
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_block_group';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'identifier', 'class'], 'required'],
            [['name', 'identifier', 'class'], 'string'],
            [['created_timestamp', 'is_deleted'], 'integer'],
            ['identifier', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
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
    
    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'identifier' => 'text',
            'class' => 'text',
            'created_timestamp' => 'datetime'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestExtraAttributeTypes()
    {
        return [
            'groupLabel' => 'text',
        ];
    }

    /**
     * Get the Group label with translation evaled.
     *
     * @return string Returns the group name.
     */
    public function getGroupLabel()
    {
        return $this->classObject->label();
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            [['list'], ['groupLabel', 'identifier', 'created_timestamp', 'class']],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['groupLabel'];
    }
    
    /**
     * Returns the block group object in order to retrieve translation data.
     *
     * @return \luya\cms\base\BlockGroup
     */
    public function getClassObject()
    {
        return Yii::createObject(['class' => $this->class]);
    }
}
