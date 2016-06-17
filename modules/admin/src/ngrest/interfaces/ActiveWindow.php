<?php

namespace admin\ngrest\interfaces;

/**
 * Active Window Interface
 * 
 * @todo rename to ActiveWindowInterface
 * @author Basil Suter <basil@nadar.io>
 */
interface ActiveWindow
{
    public function setItemId($id);

    public function getItemId();

    public function index();
}
