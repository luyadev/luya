<?php

namespace admin\ngrest\base;

interface ActiveWindowInterface
{
    public function setItemId($id);

    public function getItemId();

    public function index();

    public function setConfig($activeWindowConfig);
}
