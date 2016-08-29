<?php

namespace luya\console\interfaces;

/**
 * The interface for the Import-Controller command.
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface ImportControllerInterface
{
    /**
     * Get all files from a directory (direcotry must be in _scanFolders map). An array will be returnd with the keys
     * - file => the Filename
     * - ns => the absolut namepsace to this file.
     *
     * ```php
     * $this->getDirectoryFiles('blocks');
     * ```
     *
     * If there are no files found getDirectoryFiles will return an empty array.
     *
     * @param stirng $folderName
     *
     * @return array
     */
    public function getDirectoryFiles($folderName);

    /**
     * Add something to the output.
     *
     * ```php
     * $this->addLog(get_called_class(), 'new block <ID> have been found and added to database');
     * ```
     *
     * @param string $section
     * @param string $value
     */
    public function addLog($section, $value);
}
