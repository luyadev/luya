<?php

namespace luya\cms\base;

interface BlockInterface
{
    // user base input/config methods

    // public function extraVars();

    // public function name();

    // public function config();

    // luya based methods to access

    // public function renderFrontend();

    // public function renderAdmin();

    public function getFieldHelp();

    public function setVarValues(array $values);

    public function setCfgValues(array $values);

    public function setEnvOption($key, $value);
    
    // block unspecific methods

    public function renderFrontend();
    
    public function renderAdmin();
    
    public function name();
    
    public function config();
    
    public function extraVars();
    
    public function addExtraVar($key, $value);
}
