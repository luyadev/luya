<?php

namespace luya\admin\ngrest;

/**
 * NgRest Config Interface
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface ConfigInterface
{
    public function setConfig(array $config);

    public function getConfig();

    public function getHash();

    public function getExtraFields();

    public function onFinish();
}
