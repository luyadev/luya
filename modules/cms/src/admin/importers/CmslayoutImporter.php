<?php

namespace luya\cms\admin\importers;

use Yii;
use luya\Exception;
use luya\helpers\FileHelper;
use luya\cms\models\Layout;
use luya\console\Importer;
use yii\helpers\Inflector;

/**
 * Import cmslayout files from the folder and analyise placeholders.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class CmslayoutImporter extends Importer
{
    public $ignorePrefix = ['_', '.'];
    
    private function verifyVariable($chars)
    {
        if (preg_match('/[^a-zA-Z0-9]+/', $chars, $matches)) {
            return false;
        }
        
        return true;
    }
    
    public function generateReadableName($name)
    {
        return Inflector::humanize(Inflector::camel2words($name));
    }
    
    public function run()
    {
        $cmslayouts = Yii::getAlias('@app/views/cmslayouts');
        $layoutFiles = [];
        if (file_exists($cmslayouts)) {
            $files = FileHelper::findFiles($cmslayouts, ['recursive' => false, 'filter' => function ($path) {
                return !in_array(substr(basename($path), 0, 1), $this->ignorePrefix);
            }]);
            foreach ($files as $file) {
                $fileinfo = FileHelper::getFileInfo($file);
                
                $fileBaseName = $fileinfo->name . '.' . $fileinfo->extension;
                
                $readableFileName = $this->generateReadableName($fileinfo->name);
                
                $oldTwigName = $fileinfo->name . '.twig';
                if ($fileinfo->extension !== 'php') {
                    throw new Exception("layout file '$file': Since 1.0.0-beta6, cms layouts must be a php file with '<?= \$placeholders['content']; ?>' instead of a twig '{{placeholders.content}}'");
                }
                
                $layoutFiles[] = $fileBaseName;
                $layoutFiles[] = $oldTwigName;

                $content = file_get_contents($file);
                
                preg_match_all("/placeholders\[[\'\"](.*?)[\'\"]\]/", $content, $results);
                
                $_placeholders = [];
                foreach (array_unique($results[1]) as $holderName) {
                    if (!$this->verifyVariable($holderName)) {
                        throw new Exception("Wrong variable name detected '".$holderName."'. Special chars are not allowed in placeholder variables, allowed chars are a-zA-Z0-9");
                    }
                    $_placeholders[] = ['label' => $this->generateReadableName($holderName), 'var' => $holderName];
                }
                
                $_placeholders = ['placeholders' => $_placeholders];
                
                $layoutItem = Layout::find()->where(['or', ['view_file' => $fileBaseName], ['view_file' =>  $oldTwigName]])->one();
                
                if ($layoutItem) {
                    $match = $this->comparePlaceholders($_placeholders, json_decode($layoutItem->json_config, true));
                    if ($match) {
                        $layoutItem->updateAttributes([
                            'name' => $readableFileName,
                            'view_file' => $fileBaseName,
                        ]);
                    } else {
                        $layoutItem->updateAttributes([
                            'name' => $readableFileName,
                            'view_file' => $fileBaseName,
                            'json_config' => json_encode($_placeholders),
                        ]);
                        $this->addLog('existing cmslayout '.$readableFileName.' updated');
                    }
                } else {
                    // add item into the database table
                    $data = new Layout();
                    $data->scenario = 'restcreate';
                    $data->setAttributes([
                        'name' => $readableFileName,
                        'view_file' => $fileBaseName,
                        'json_config' => json_encode($_placeholders),
                    ]);
                    $data->save(false);
                    $this->addLog('new cmslayout '.$readableFileName.' found and added to database.');
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
