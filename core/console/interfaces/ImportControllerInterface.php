<?php

namespace luya\console\interfaces;

/**
 * Command ImportController Interface.
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface ImportControllerInterface
{
    /**
     * Get all files from a directory.
     * 
     * The direcotry must be in _scanFolders map of the {{luya\console\commands\ImporterController}}. An array will be returnd with the keys:
     * 
     * + file: The name of the file inside the provided folder (e.g. MyBlock.php)
     * + module: The name of the module where the file belongs to. 
     * + ns: The namespace for the file including the filename itself.
     *
     * Usage example:
     * 
     * ```php
     * $this->getDirectoryFiles('blocks');
     * ```
     *
     * If there are no files found getDirectoryFiles will return an empty array.
     *
     * @param stirng $folderName The folder name to find all files from.
     * @return array If no files found for the given folder an empty array will be returned, otherwise a list of all files inside the given folder.
     */
    public function getDirectoryFiles($folderName);

    /**
     * Add something to the log output.
     *
     * ```php
     * $this->addLog(get_called_class(), 'new block <ID> have been found and added to database');
     * ```
     *
     * @param string $section The section of where the log is executed.
     * @param string $value The message to log.
     */
    public function addLog($section, $value);
}
