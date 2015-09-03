<?php

namespace luya\interfaces;

interface ImportCommand
{
    public function getDirectoryFiles($folderName);

    public function addLog($section, $value);
}
