<?php

namespace admin\ngrest\interfaces;

interface ActiveWindow
{
    public function setItemId($id);

    public function getItemId();

    public function index();

    public function setConfig(array $activeWindowConfig);
}
