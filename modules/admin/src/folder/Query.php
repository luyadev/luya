<?php

namespace luya\admin\folder;

use Yii;

/**
 * @property object $storage The storage component
 *
 * @author nadar
 */
class Query extends \yii\base\Object
{
    use \luya\admin\storage\QueryTrait;
    
    private $_storage = null;
    
    /**
     * Singleton behavior for storage component getter.
     *
     * @return \admin\components\StorageContainer
     */
    public function getStorage()
    {
        if ($this->_storage === null) {
            $this->_storage = Yii::$app->storage;
        }
    
        return $this->_storage;
    }
    
    public function getDataProvider()
    {
        return $this->storage->foldersArray;
    }
    
    public function getItemDataProvider($id)
    {
        return $this->storage->getFoldersArrayItem($id);
    }
    
    public function createItem(array $itemArray)
    {
        return Item::create($itemArray);
    }
    
    public function createIteratorObject(array $data)
    {
        return Yii::createObject(['class' => Iterator::className(), 'data' => $data]);
    }
}
