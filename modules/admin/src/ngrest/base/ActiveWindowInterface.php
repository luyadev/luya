<?php

namespace luya\admin\ngrest\base;

/**
 * Active Window Interface
 *
 * @todo rename to ActiveWindowInterface
 * @author Basil Suter <basil@nadar.io>
 */
interface ActiveWindowInterface
{
    public function setItemId($id);

    public function setConfigHash($hash);
    
    public function setActiveWindowHash($hash);
    
    public function getItemId();

    public function index();
}
