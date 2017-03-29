<?php

namespace luya\cms\models;

use Yii;
use luya\cms\base\BlockInterface;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Block ActiveRecord contains the Block<->Group relation.
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $class
 * @author Basil Suter <basil@nadar.io>
 */
class Block extends NgRestModel
{
    private $cachedDeletedId = 0;

    public static function ngRestApiEndpoint()
    {
        return 'api-cms-block';
    }

    public static function tableName()
    {
        return 'cms_block';
    }
    
    public function extraFields()
    {
        return ['usageCount'];
    }
    
    public function ngRestAttributeTypes()
    {
        return [
            'group_id' => ['selectModel', 'modelClass' => BlockGroup::className(), 'valueField' => 'id', 'labelField' => 'name'],
            'class' => 'text',
        ];
    }
    
    public function ngRestExtraAttributeTypes()
    {
        return [
            'usageCount' => 'number',
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group',
            'class' => 'Object Class',
            'usageCount' => 'Used in Content'
        ];
    }

    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, ['list'], ['group_id', 'class', 'usageCount']);
        
        return $config;
    }

    public function getUsageCount()
    {
        return NavItemPageBlockItem::find()->where(['block_id' => $this->id])->count();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'class'], 'required'],
            [['group_id'], 'integer'],
            [['class'], 'string', 'max' => 255],
        ];
    }
    
    public function ngRestGroupByField()
    {
        return 'group_id';
    }

    /**
     * Save id before deleting for clean up in afterDelete()
     *
     * @return bool
     */
    public function beforeDelete()
    {
        $this->cachedDeletedId = $this->id;
        return parent::beforeDelete();
    }

    /**
     * Search for entries with cached block id in cms_nav_item_page_block_item and delete them
     */
    public function afterDelete()
    {
        if ($this->cachedDeletedId) {
            foreach (NavItemPageBlockItem::find()->where(['block_id' => $this->cachedDeletedId])->all() as $item) {
                $item->delete();
            }
        }
        parent::afterDelete();
    }

    public function getObject()
    {
        return Yii::createObject([
            'class' => $this->class,
        ]);
    }
    
    /**
     * Try to get the name of the log.
     */
    public function getNameForLog()
    {
        if ($this->object && $this->object instanceof BlockInterface) {
            return $this->object->name();
        }
        
        return $this->class;
    }
    
    private static $blocks = [];
    
    /**
     * Get the block object from the database with context informations.
     *
     * @param unknown $blockId
     * @param unknown $id
     * @param unknown $context
     * @param unknown $pageObject
     * @return boolean|object|mixed
     */
    public static function objectId($blockId, $id, $context, $pageObject = null)
    {
        if (isset(self::$blocks[$blockId])) {
            $block = self::$blocks[$blockId];
        } else {
            $block = self::find()->select(['class'])->where(['id' => $blockId])->asArray()->one();
            static::$blocks[$blockId] = $block;
        }
        
        if (!$block) {
            return false;
        }

        $class = $block['class'];
        if (!class_exists($class)) {
            return false;
        }

        $object = Yii::createObject([
            'class' => $class,
        ]);

        $object->setEnvOption('id', $id);
        $object->setEnvOption('blockId', $blockId);
        $object->setEnvOption('context', $context);
        $object->setEnvOption('pageObject', $pageObject);

        return $object;
    }
}
