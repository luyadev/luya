<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Console;
use yii\imagine\Image;

/**
 * Health/Status informations about the Application itself.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class HealthController extends \luya\console\Command
{
    /**
     * @var array An array with all folders to check where the value for the key is whether it should be writeable or not.
     */
    public $folders = [
        'public_html/assets' => true,
        'public_html/storage' => true,
        'migrations' => false,
        'vendor' => false,
        'runtime' => true,
    ];

    /**
     * @var array An array with files to check if they exists or not.
     */
    public $files = [
        'configs/env.php',
        'public_html/index.php',
    ];
    
    /**
     * Create all required directories an check whether they are writeable or not.
     *
     * @return string The action output.
     */
    public function actionIndex()
    {
        $error = false;

        @chdir(Yii::getAlias('@app'));

        $this->output('The directory the health commands is applying to: ' . Yii::getAlias('@app'));
        
        foreach ($this->folders as $folder => $writable) {
            $mode = ($writable) ? 0777 : 0775;
            if (!file_exists($folder)) {
                if (FileHelper::createDirectory($folder, $mode)) {
                    $this->outputSuccess("$folder: successfully created directory");
                } else {
                    $error = true;
                    $this->outputError("$folder: unable to create directory");
                }
            } else {
                $this->outputInfo("$folder: directory exists already");
            }
            
            if ($writable && !is_writable($folder)) {
                $this->outputInfo("$folder: is not writeable, try to set mode '$mode'.");
                @chmod($folder, $mode);
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
                $this->outputInfo("$file: file exists.");
            } else {
                $error = true;
                $this->outputError("$file: file does not exists!");
            }
        }

        /*
         * move to admin/setup command as part of admin setup.
        try {
            Image::getImagine();
        } catch (\Exception $e) {
            $this->outputError('Imagine Error: ' . $e->getMessage());
        }
        */
        
        return ($error) ? $this->outputError('Health check found errors!') : $this->outputSuccess('O.K.');
    }

    /**
     * Test Mail-Component (Use --verbose=1 to enable smtp debug output)
     *
     * @return boolean Whether successfull or not.
     * @throws Exception On smtp failure
     */
    public function actionMailer()
    {
        try {
            if (Yii::$app->mail->smtpTest($this->verbose)) {
                return $this->outputSuccess("successfull connected to SMTP Server '".Yii::$app->mail->host."'");
            }
        } catch (\Exception $e) {
            return $this->outputError($e->getMessage());
        }
    }
}
