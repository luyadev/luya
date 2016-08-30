<?php

namespace luya\admin\ngrest\render;

use Yii;
use luya\admin\ngrest\base\Render;

/**
 * @author nadar
 */
class RenderActiveWindow extends Render implements RenderInterface
{
    private $_itemId = null;

    public $activeWindowHash = null;
    
    public function render()
    {
        if (($activeWindow = $this->findActiveWindow($this->activeWindowHash)) !== false) {
            $object = Yii::createObject($activeWindow['objectConfig']);
            $object->setItemId($this->_itemId);
            Yii::$app->session->set($this->activeWindowHash, $this->_itemId);
            return $object->index();
        }
    }

    public function setActiveWindowHash($activeWindowHash)
    {
        $this->activeWindowHash = $activeWindowHash;
    }

    public function setItemId($id)
    {
        $this->_itemId = (int) $id;
    }

    public function findActiveWindow($activeWindowHash)
    {
        $activeWindows = $this->config->getPointer('aw');
        if (array_key_exists($activeWindowHash, $activeWindows)) {
            return $activeWindows[$activeWindowHash];
        }

        return false;
    }
}
