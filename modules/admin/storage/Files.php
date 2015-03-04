<?php
namespace admin\storage;

class Files
{
    public function createFile($path, $hidden = false)
    {
        // make database entry, save file with new name into $this->getModule('admin')->storagePath;
        
        // if hidden is true, the file will not be display in a folder
        
        return 1; // return the file id from the table
    }
    
    public function createFolder($folderName, $parentFolderId = 0)
    {
        
    }
    
    public function moveFileToFolder($fileId, $folderId)
    {
        
    }
}