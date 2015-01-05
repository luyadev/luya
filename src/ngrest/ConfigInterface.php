<?php
namespace luya\ngrest;

interface ConfigInterface
{
    public function get();

    public function getKey($key);

    public function getRestUrl();

    public function getRestPrimaryKey();

    public function getNgRestConfigHash();
}
