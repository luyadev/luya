<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\FileHelper;

class HealthController extends \luya\console\Command
{
    public $folders = [
        'public_html/assets' => true,
        'public_html/storage' => true,
        'migrations' => false,
        'vendor' => false,
        'runtime' => true,
    ];

    public $files = [
        'configs/server.php',
        'public_html/index.php',
    ];

    public function actionIndex()
    {
        $error = false;

        @chdir(Yii::getAlias('@app'));

        foreach ($this->folders as $folder => $writable) {
            if (!file_exists($folder)) {
                $mode = ($writable) ? 0777 : 0775;
                if (FileHelper::createDirectory($folder, $mode)) {
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
                    $this->outputError("$folder: is not writable, please change permissions.");
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
    
    public function actionMailer()
    {
        try {
            if (Yii::$app->mail->smtpTest()) {
                return $this->outputSuccess("successfull connected to SMTP Server '" . Yii::$app->mail->host . "'");
            }
        } catch (\Exception $e) {
            return $this->outputError($e->getMessage());
        }
    }
}
