<?php
namespace admin\ngrest;

interface ConfigInterface
{
    public function get();

    public function getKey($key);

    public function getRestUrl();

    public function getRestPrimaryKey();

    public function getOption($key, $defaultValue = '');

    public function getNgRestConfigHash();

    public function onFinish();
}
