<?php

namespace tests\web\admin\models;

class StroageFileTest extends \tests\web\BaseModel
{
    public $createScenario = 'default';

    public $updateScenario = 'default';

    public function getModel()
    {
        return new \admin\models\StorageFile();
    }

    public function getParams()
    {
        return [
            'name_original', 'name_new', 'mime_type', 'name_new_compound', 'extension', 'hash_file', 'hash_name', 'folder_id', 'upload_timestamp', 'file_size', 'upload_user_id', 'upload_timestamp',
        ];
    }
}
