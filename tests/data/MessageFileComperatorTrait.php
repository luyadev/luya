<?php

namespace luyatests\data;

use yii\helpers\FileHelper;

trait MessageFileComperatorTrait
{
    public function compare($folder, $masterLang)
    {
        $folders = [];

        foreach (scandir($folder) as $item) {
            if (is_dir($folder . DIRECTORY_SEPARATOR . $item) && $item !== '..' && $item !== '.') {
                $folders[$item] = $folder . DIRECTORY_SEPARATOR . $item;
            }
        }

        $master = $folders[$masterLang];
        unset($folders[$masterLang]);
        $masterFiles = FileHelper::findFiles($master);

        foreach ($folders as $dir) {
            foreach (FileHelper::findFiles($dir) as $file) {
                foreach ($masterFiles as $mf) {
                    if (basename($file) == basename($mf)) {
                        $materArray = include($mf);
                    }
                }

                $compareArray = include($file);

                foreach ($materArray as $key => $value) {
                    $this->assertArrayHasKey($key, $compareArray, "The language key '{$key}' does not exists in the language file '{$file}'.");
                }
            }
        }
    }
}
