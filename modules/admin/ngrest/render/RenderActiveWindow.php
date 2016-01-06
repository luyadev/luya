<?php

namespace admin\ngrest\render;

/**
 * @author nadar
 */
class RenderActiveWindow extends \admin\ngrest\base\Render implements \admin\ngrest\interfaces\Render
{
    private $_itemId = null;

    public $activeWindowHash = null;
    
    public function render()
    {
        if (($activeWindow = $this->findActiveWindow($this->activeWindowHash)) !== false) {
            $object = $activeWindow['object'];
            unset($activeWindow['object']);
            $object->setItemId($this->_itemId);
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
