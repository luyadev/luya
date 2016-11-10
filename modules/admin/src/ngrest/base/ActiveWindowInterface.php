<?php

namespace luya\admin\ngrest\base;

/**
 * Active Window Interface.
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface ActiveWindowInterface
{
    /**
     * Get the item id of the current ActiveWindow context item id.
     *
     * @return integer The id of the current context item.
     */
    public function getItemId();
    
    /**
     * Set the value of the item Id in where the active window context is initialized.
     *
     * @param integer $itemId The item id context
     */
    public function setItemId($id);

    /**
     * Set the current configratuion hash name to the ActiveWindow.
     *
     * Setting the the hash happens in the {{luya\admin\ngrest\render\RenderActiveWindow::render}} method.
     *
     * @param string $hash The hash name of the current active config.
     */
    public function setConfigHash($hash);
    
    /**
     * Set the hash of the current active window which is calculated by the ActiveWindow.
     *
     * Setting the the hash happens in the {{luya\admin\ngrest\render\RenderActiveWindow::render}} method.
     * @param unknown $hash
     */
    public function setActiveWindowHash($hash);
    
    /**
     * The default action which is going to be requested when clicking the active window.
     *
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index();
}
