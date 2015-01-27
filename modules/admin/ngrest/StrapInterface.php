<?php
namespace admin\ngrest;

interface StrapInterface
{
    public function setItemId($id);

    public function getItemId();

    public function render();

    public function setConfig($strapConfig);
}
