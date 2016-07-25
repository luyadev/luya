<?php

namespace cmsadmin\base;

interface TwigBlockInterface
{
    public function twigFrontend();
    
    public function twigAdmin();
    
    public function render();
}