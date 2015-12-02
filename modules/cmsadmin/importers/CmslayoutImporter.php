<?php

namespace cmsadmin\importers;

use Yii;
use Exception;
use cmsadmin\models\Layout;
use yii\db\yii\db;

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
                $layoutFiles[] = $file;
                $layoutItem = Layout::find()->where(['view_file' => $file])->one();

                $content = file_get_contents($cmslayouts.DIRECTORY_SEPARATOR.$file);
                // find all twig brackets
                preg_match_all("/\{\{(.*?)\}\}/", $content, $results);
                // local vars
                $_placeholders = [];
                // explode the specific vars for each type
                foreach ($results[1] as $match) {
                    $parts = explode('.', trim($match));
                    switch ($parts[0]) {
                        case 'placeholders':
                            
                            if (!$this->verifyVariable($parts[1])) {
                                throw new Exception("Wrong variable name detected '".$parts[1]."'. Special chars are not allowed in placeholder variables, allowed chars are a-zA-Z0-9");
                            }
                            
                            $_placeholders[] = ['label' => $parts[1], 'var' => $parts[1]];
                            break;
                    }
                }

                $_placeholders = ['placeholders' => $_placeholders];
                if ($layoutItem) {
                    $match = $this->comparePlaceholders($_placeholders, json_decode($layoutItem->json_config, true));
                    if ($match) {
                        $this->getImporter()->addLog('layouts', 'existing cmslayout '.$file.' does not have changed.');
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
