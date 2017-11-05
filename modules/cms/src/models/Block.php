<?php

namespace luya\cms\models;

use Yii;
use luya\cms\base\BlockInterface;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\DetailViewActiveWindow;
use luya\admin\ngrest\plugins\SelectModel;

/**
 * Block ActiveRecord contains the Block<->Group relation.
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $class
 * @property integer $usageCount returns the amount of how much this block is used inside a page.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Block extends NgRestModel
{
    private $cachedDeletedId = 0;

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-cms-block';
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_block';
    }
    
    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['usageCount', 'translationName'];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'group_id' => [
                'class' => SelectModel::class,
                'modelClass' => BlockGroup::className(),
                'labelField' => function ($model) {
                    return $model->getGroupLabel();
                }
            ],
            'class' => 'text',
            'is_disabled' => 'toggleStatus',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestExtraAttributeTypes()
    {
        return [
            'usageCount' => 'number',
            'translationName' => 'text',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group',
            'class' => 'Object Class',
            'usageCount' => 'Used in Content',
            'is_disabled' => 'Is Disabled',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestActiveWindows()
    {
        return [
            ['class' => DetailViewActiveWindow::class],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['translationName', 'group_id', 'usageCount', 'is_disabled']],
        ];
    }

    /**
     * Returns the amount where the block is used inside the content.
     *
     * @return integer
     */
    public function getUsageCount()
    {
        return NavItemPageBlockItem::find()->where(['block_id' => $this->id])->count();
    }
    
    /**
     * Returns the name from the block label.
     *
     * @return string
     */
    public function getTranslationName()
    {
        return $this->getClassObject()->name();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'class'], 'required'],
            [['group_id', 'is_disabled'], 'integer'],
            [['class'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * @inheritdoc
     */
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

    /**
     * Returns the object class based on the Active Record entry.
     *
     * @return \luya\cms\base\BlockInterface
     * @deprecated use get ClassObject Instead
     */
    public function getObject()
    {
        trigger_error('This method is deprecated use getClassObject() instead.', E_USER_DEPRECATED);
        
        return $this->getClassObject();
    }

    /**
     * Returns the origin block object based on the current active record entry.
     *
     * @return \luya\cms\base\BlockInterface
     */
    public function getClassObject()
    {
        return Yii::createObject(['class' => $this->class]);
    }
    
    /**
     * Try to get the name of the log.
     */
    public function getNameForLog()
    {
        if ($this->getClassObject() && $this->getClassObject() instanceof BlockInterface) {
            return $this->getClassObject()->name();
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
     * @return \luya\cms\base\BlockInterface
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
