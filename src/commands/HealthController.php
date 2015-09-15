<?php

namespace luya\commands;

use yii\helpers\FileHelper;

class HealthController extends \luya\base\Command
{
    public $folders = [
        'public_html/assets' => true,
        'public_html/storage' => true,
        'migrations' => false,
        'vendor' => false,
    ];

    public $files = [
        'configs/server.php',
        'public_html/index.php',
    ];

    public function actionIndex()
    {
        $error = false;

        foreach ($this->folders as $folder => $writable) {
            if (!file_exists($folder)) {
                if (FileHelper::createDirectory($folder)) {
                    $this->outputSuccess("$folder: successfully created directory");
                } else {
                    $error = true;
                    $this->outputError("$folder: unable to create directory");
                }
            } else {
                $this->outputSuccess("$folder: directory exists");
            }
            
            if ($writable) {
                if (!is_writable($folder)) {
                    $error = true;
                    $this->outputError("$folder: is not writable.");
                }
            }
        }

        foreach ($this->files as $file) {
            if (file_exists($file)) {
                $this->outputSuccess("$file: file exists.");
            } else {
                $error = true;
                $this->outputError("$file: file does not exists!");
            }
        }

        return ($error) ? $this->outputError('Health check found errors!') : $this->outputSuccess('O.K.');
    }
}
