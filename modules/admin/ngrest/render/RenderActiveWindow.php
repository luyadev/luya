<?php

namespace admin\ngrest\render;

use admin\ngrest\RenderAbstract;
use admin\ngrest\RenderInterface;

/**
 * @todo complet rewrite of this class - what is the best practive to acces data in the view? define all functiosn sindie here? re-create methods from config object?
 *  $this->config() $this....
 *
 * @author nadar
 */
class RenderActiveWindow extends RenderAbstract implements RenderInterface
{
    private $itemId = null;

    public function render()
    {
        if (($activeWindow = $this->findActiveWindow($this->activeWindowHash)) !== false) {
            $object = $activeWindow['object'];
            unset($activeWindow['object']);
            $object->setConfig($activeWindow);
            $object->setItemId($this->itemId);

            return $object->index();
        }
    }

    public function setActiveWindowHash($activeWindowHash)
    {
        $this->activeWindowHash = $activeWindowHash;
    }

    public function setItemId($id)
    {
        $this->itemId = $id;
    }

    public function findActiveWindow($activeWindowHash)
    {
        $activeWindows = $this->config->getKey('activeWindow');
        if (array_key_exists($activeWindowHash, $activeWindows)) {
            return $activeWindows[$activeWindowHash];
        }

        return false;
    }
}
