<?php

namespace cmsadmin\base;

interface BlockInterface
{
    // user base input/config methods
    
    public function extraVars();

    public function name();

    public function config();

    public function twigFrontend();

    public function twigAdmin();

    // luya based methods to access
    
    public function getTwigFrontendContent();

    public function setVarValues(array $values);

    public function setCfgValues(array $values);

    public function setEnvOption($key, $value);
}
