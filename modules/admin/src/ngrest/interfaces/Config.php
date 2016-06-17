<?php

namespace admin\ngrest\interfaces;

/**
 * NgRest Config Interface
 * 
 * @todo rename to ConfigInterface
 * @author Basil Suter <basil@nadar.io>
 */
interface Config
{
    public function setConfig(array $config);

    public function getConfig();

    public function getHash();

    public function getExtraFields();

    public function onFinish();
}
