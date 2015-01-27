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
class RenderStrap extends RenderAbstract implements RenderInterface
{
    private $itemId = null;

    public function render()
    {
        if (($strap = $this->findStrap($this->strapHash)) !== false) {
            $object = $strap['object'];
            unset($strap['object']);
            $object->setConfig($strap);
            $object->setItemId($this->itemId);

            return $object->render();
        }
    }

    public function setStrapHash($strapHash)
    {
        $this->strapHash = $strapHash;
    }

    public function setItemId($id)
    {
        $this->itemId = $id;
    }

    public function findStrap($strapHash)
    {
        $straps = $this->config->getKey('strap');
        if (array_key_exists($strapHash, $straps)) {
            return $straps[$strapHash];
        }

        return false;
    }
}
