<?php

namespace luya\admin\file;

use Yii;
use luya\admin\storage\QueryTrait;
use yii\base\BaseObject;

/**
 * Storage Files Querying.
 *
 * See the {{\luya\admin\storage\QueryTrait}} for more informations.
 *
 * @property \luya\admin\storage\BaseFileSystemStorage $storage The storage component
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Query extends BaseObject
{
    use QueryTrait;
    
    private $_storage;
    
    /**
     * Singleton behavior for storage component getter.
     *
     * @return \luya\admin\storage\BaseFileSystemStorage
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
        return $this->storage->filesArray;
    }
    
    public function getItemDataProvider($id)
    {
        return $this->storage->getFilesArrayItem($id);
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
