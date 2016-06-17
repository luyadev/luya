<?php

namespace cmsadmin\models;

use Yii;

/**
 * Block ActiveRecord contains the Block<->Group relation.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Block extends \admin\ngrest\base\Model
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
    
    public function ngrestAttributeTypes()
    {
        return [
            'group_id' => ['selectModel', 'modelClass' => BlockGroup::className(), 'valueField' => 'id', 'labelField' => 'name'],
            'class' => 'text',
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group',
            'class' => 'Object Class',
        ];
    }

    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, ['list'], ['group_id', 'class']);
        
        return $config;
    }

    public function rules()
    {
        return [
            [['class', 'group_id'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'commandinsert' => ['class', 'group_id'],
            'restcreate' => ['class', 'group_id'],
            'restupdate' => ['class', 'group_id'],
        ];
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

    public static function objectId($blockId, $id, $context, $pageObject = null)
    {
        $block = self::find()->where(['id' => $blockId])->asArray()->one();
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
