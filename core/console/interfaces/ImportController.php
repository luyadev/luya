<?php

namespace luya\console\interfaces;

interface ImportController
{
    public function getDirectoryFiles($folderName);

    public function addLog($section, $value);
}
