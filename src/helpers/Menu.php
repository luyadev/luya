<?php
namespace luya\helpers;

/**
 * should be in cms helpers?
 * @author nadar
 *
 */
class Menu
{
    /**
     *
     * @param Links $linksCollection
     * @param integer $level 1 = first, 2 = second, 3 = third
     */
    public static function parentNavIdByCurrentLink(\luya\collection\Links $linksCollection, $level)
    {
        if ($level == 1) {
            return 0;
        }
        
        $tree = $linksCollection->teardown($linksCollection->getActiveLink());
        
        $index = ($level - 2);
        return (array_key_exists($index, $tree)) ? $tree[$index]['id'] : false;
    }
}
