<?php
namespace luya\ngrest;

interface RenderInterface
{
    public function setConfig(Config $config);
    
    public function render();
}