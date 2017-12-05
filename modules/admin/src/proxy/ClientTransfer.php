<?php

namespace luya\admin\proxy;

use Curl\Curl;
use luya\admin\file\Query;
use luya\traits\CacheableTrait;
use luya\helpers\FileHelper;
use yii\base\BaseObject;

/**
 * Admin Proxy commands Transfer Files.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ClientTransfer extends BaseObject
{
    use CacheableTrait;
    
    /**
     * @var \luya\admin\proxy\ClientBuild
     */
    public $build;
    
    public function start()
    {
        $this->flushHasCache();
        
        foreach ($this->build->getTables() as $name => $table) {
            /* @var $table \luya\admin\proxy\ClientTable */
            if (!$table->isComplet()) {
                if ($this->build->optionStrict) {
                    $this->build->command->outputInfo('Rows Expected: ' . $table->getRows());
                    $this->build->command->outputInfo('Rows Downloaded: ' . count($table->getContentRows()));
                    return $this->build->command->outputError('Incomplet build, stop execution: ' . $name);
                }
            }
        }
        foreach ($this->build->getTables() as $name => $table) {
            $table->syncData();
        }
        
        $fileCount = 0;
        
        // sync files
        foreach ((new Query())->where(['is_deleted' => false])->all() as $file) {
            /* @var $file \luya\admin\file\Item */
            if (!$file->fileExists) {
                $curl = new Curl();
                $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
                $curl->get($this->build->fileProviderUrl, [
                    'buildToken' => $this->build->buildToken,
                    'machine' => $this->build->machineIdentifier,
                    'fileId' => $file->id,
                ]);
                
                if (!$curl->error) {
                    if (FileHelper::writeFile($file->serverSource, $curl->response)) {
                        $md5 = FileHelper::md5sum($file->serverSource);
                        if ($md5 == $file->getFileHash()) {
                            $fileCount++;
                            $this->build->command->outputInfo('[+] File ' . $file->name . ' ('.$file->systemFileName.') downloaded.');
                        } else {
                            $this->build->command->outputError('[!] Downloaded file checksum "'.$md5.'" does not match server checksum "'.$file->getFileHash().'" for file ' . $file->systemFileName.'.');
                            @unlink($file->serverSource);
                        }
                    }
                } else {
                    $this->build->command->outputError('[!] File ' . $file->systemFileName. ' download request error: "'. $curl->error_message.'".');
                }
                
                $curl->close();
                unset($curl);
                gc_collect_cycles();
            }
        }
        
        $this->build->command->outputInfo("[=] {$fileCount} Files downloaded.");
        
        $imageCount = 0;
        
        // sync images
        foreach ((new \luya\admin\image\Query())->all() as $image) {
            /* @var $image \luya\admin\image\Item */
            if (!$image->fileExists) {
                $curl = new Curl();
                $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
                $curl->get($this->build->imageProviderUrl, [
                    'buildToken' => $this->build->buildToken,
                    'machine' => $this->build->machineIdentifier,
                    'imageId' => $image->id,
                ]);
            
                if (!$curl->error) {
                    if (FileHelper::writeFile($image->serverSource, $curl->response)) {
                        $imageCount++;
                        $this->build->command->outputInfo('[+] Image ' . $image->source.' downloaded.');
                    }
                }
                
                $curl->close();
                unset($curl);
                gc_collect_cycles();
            }
        }
        
        $this->build->command->outputInfo("[=] {$imageCount} Images downloaded.");
        
        // close the build
        $curl = new Curl();
        $curl->get($this->build->requestCloseUrl, ['buildToken' => $this->build->buildToken]);
        
        return true;
    }
}
