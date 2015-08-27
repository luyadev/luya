<?php

namespace cmsadmin\base;

interface BlockInterface
{
    public function extraVars();

    public function name();

    public function config();

    public function twigFrontend();

    public function twigAdmin();

    public function getTwigFrontendContent();

    public function setVarValues(array $values);

    public function setCfgValues(array $values);

    public function setEnvOption($key, $value);
}
