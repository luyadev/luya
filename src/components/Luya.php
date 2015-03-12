<?php
namespace luya\components;

/**
 * allow the ability to register different services of luya.
 *
 * @author nadar
 */
class Luya extends \yii\base\Component
{
    private $_storage = null;

    public function getStorage()
    {
        if (empty($this->_storage)) {
            throw new \Exception("No storage container as been defined yet");
        }

        return $this->_storage;
    }

    public function setStorage($storage)
    {
        if (!empty($this->_storage)) {
            throw new \Exception("another storage service have been registered already.");
        }

        $this->_storage = $storage;
    }
}
