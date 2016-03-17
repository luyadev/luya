<?php

namespace cmsadmin\importers;

use Yii;
use Exception;
use cmsadmin\models\Layout;
use yii\db\yii\db;
use luya\helpers\FileHelper;

class CmslayoutImporter extends \luya\base\Importer
{
    private function verifyVariable($chars)
    {
        if (preg_match('/[^a-zA-Z0-9]+/', $chars, $matches)) {
            return false;
        }
        
        return true;
    }
    
    public function run()
    {
        $cmslayouts = Yii::getAlias('@app/views/cmslayouts');
        $layoutFiles = [];
        if (file_exists($cmslayouts)) {
            foreach (scandir($cmslayouts) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                
                $fileinfo = FileHelper::getFileInfo($file);
                $oldTwigName = $fileinfo->name . '.twig';
                if ($fileinfo->extension !== 'php') {
                    throw new Exception("layout file '$file': Since 1.0.0-beta6, cms layouts must be a php file with '<?= \$placeholders['content']; ?>' instead of a twig '{{placeholders.content}}'");
                }
                
                $layoutFiles[] = $file;
                $layoutFiles[] = $oldTwigName;
                

                $content = file_get_contents($cmslayouts.DIRECTORY_SEPARATOR.$file);
                
                preg_match_all("/placeholders\[[\'\"](.*?)[\'\"]\]/", $content, $results);
                
                $_placeholders = [];
                foreach ($results[1] as $holderName) {
                    if (!$this->verifyVariable($holderName)) {
                        throw new Exception("Wrong variable name detected '".$holderName."'. Special chars are not allowed in placeholder variables, allowed chars are a-zA-Z0-9");
                    }
                    $_placeholders[] = ['label' => $holderName, 'var' => $holderName];
                }
                
                $_placeholders = ['placeholders' => $_placeholders];
                
                $layoutItem = Layout::find()->where(['or', ['view_file' => $file], ['view_file' =>  $oldTwigName]])->one();
                
                if ($layoutItem) {
                    $match = $this->comparePlaceholders($_placeholders, json_decode($layoutItem->json_config, true));
                    if ($match) {
                        $layoutItem->scenario = 'restupdate';
                        $layoutItem->setAttributes([
                            'name' => ucfirst($file),
                            'view_file' => $file,
                        ]);
                        $layoutItem->save();
                        continue;
                    }
                    $layoutItem->scenario = 'restupdate';
                    $layoutItem->setAttributes([
                        'name' => ucfirst($file),
                        'view_file' => $file,
                        'json_config' => json_encode($_placeholders),
                    ]);
                    $layoutItem->save();
                    $this->getImporter()->addLog('layouts', 'existing cmslayout '.$file.' updated');
                } else {
                    // add item into the database table
                    $data = new Layout();
                    $data->scenario = 'restcreate';
                    $data->setAttributes([
                        'name' => ucfirst($file),
                        'view_file' => $file,
                        'json_config' => json_encode($_placeholders),
                    ]);
                    $data->save();
                    $this->getImporter()->addLog('layouts', 'new cmslayout '.$file.' found and added to databse.');
                }
            }

            foreach (Layout::find()->where(['not in', 'view_file', $layoutFiles])->all() as $layoutItem) {
                $layoutItem->delete();
            }
        }
    }

    /**
     * @param array $array1
     * @param array $array2
     *
     * @return bool true if the same, false if not the same
     */
    private function comparePlaceholders($array1, $array2)
    {
        if (!array_key_exists('placeholders', $array1) || !array_key_exists('placeholders', $array2)) {
            return false;
        }

        $a1 = $array1['placeholders'];
        $a2 = $array2['placeholders'];

        if (count($a1) !== count($a2)) {
            return false;
        }

        foreach ($a1 as $key => $holder) {
            if (!array_key_exists($key, $a2)) {
                return false;
            }

            foreach ($holder as $var => $value) {
                if ($var == "label") {
                    continue;
                }
                
                if (!array_key_exists($var, $a2[$key])) {
                    return false;
                }

                if ($value != $a2[$key][$var]) {
                    return false;
                }
            }
        }

        return true;
    }
}
