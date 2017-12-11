<?php

namespace luya\cms\frontend\commands;

use Yii;
use luya\console\Command;
use luya\admin\models\Config;
use luya\cms\models\NavItem;
use luya\cms\admin\Module;
use luya\cms\models\Block;
use luya\helpers\StringHelper;
use luya\cms\Exception;

/**
 * This controller is part of the beta6 release and adds the version ability database migrations.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class UpdaterController extends Command
{
    const MIGRATION_CODE_100 = '100genericBlockUpdate';
    
    public function actionGeneric()
    {
        if (Config::has(self::MIGRATION_CODE_100)) {
            return $this->outputError("Command already executed. System is up-to-date.");
        }
        
        $this->outputInfo("Questions or Problems? read more at https://github.com/luyadev/luya/issues/1572");
        
        if (!$this->confirm("Warning: Have you made a database backup? If something goes wrong, the website content is unrecoverable lost!")) {
            return $this->outputError("Make a backup first!");
        }
        
        // check if this application has cms blocks.
        if (!Block::find()->where(['like', 'class', '\\luya\\cms'])->exists()) {
            if ($this->confirm("There are no cms blocks registered, is this right?")) {
                return $this->closeMigration(self::MIGRATION_CODE_100);
            } else {
                throw new Exception("Contact the LUYA Slack community, otherwise all your existing blocks will be removed from database.");
            }
        }
        
        // check if this application has registered the new generic block package.
        $genericExists = false;
        $bs3Exists = false;
        foreach (Yii::$app->packageInstaller->configs as $config) {
            if ($config->package['name'] == "luyadev/luya-generic") {
                $genericExists = true;
            }
            if ($config->package['name'] == "luyadev/luya-bootstrap3") {
                $bs3Exists = true;
            }
        }
        if (!$genericExists || !$bs3Exists) {
            return $this->outputError("Register the `luyadev/luya-generic` and `luyadev/luya-bootstrap3` package in your composer.json run update and run this command again.");
        }
        
        $mappings = [
            'AudioBlock' => 'delete',
            'DevBlock' => 'delete',
            'FileListBlock' => 'luya\\generic\\blocks',
            'FormBlock' => 'luya\\bootstrap3\\blocks',
            'HtmlBlock' => 'luya\\cms\\frontend\\blocks',
            'ImageBlock' => 'luya\\bootstrap3\\blocks',
            'ImageTextBlock' => 'luya\\bootstrap3\\blocks',
            'LayoutBlock' => 'luya\\bootstrap3\\blocks',
            'LineBlock' => 'luya\\generic\\blocks',
            'LinkButtonBlock' => 'luya\\bootstrap3\\blocks',
            'ListBlock' => 'luya\\generic\\blocks',
            'MapBlock' => 'luya\\bootstrap3\\blocks',
            'ModuleBlock' => 'luya\\cms\\frontend\\blocks',
            'QuoteBlock' => 'luya\\generic\\blocks',
            'SpacingBlock' => 'luya\\bootstrap3\\blocks',
            'TableBlock' => 'luya\\bootstrap3\\blocks',
            'TextBlock' => 'luya\\generic\\blocks',
            'TitleBlock' => 'luya\\generic\\blocks',
            'VideoBlock' => 'luya\\bootstrap3\\blocks',
            'WysiwygBlock' => 'luya\\generic\\blocks',
        ];
        
        // change namespace from existing cms block to new generic block package.
        foreach (Block::find()->where(['like', 'class', '\\luya\\cms'])->all() as $block) {
            $originClassName = str_replace("luya\\cms\\frontend\\blocks\\", "", $block->class);
            
            $originClassName = ltrim($originClassName, '\\');
            
            if (!array_key_exists($originClassName, $mappings)) {
                throw new Exception("The class '{$originClassName}' does not exists in the mapping list!");
            }
            
            // delete blocks from delete section (audio and dev)
            if ($mappings[$originClassName] == 'delete') {
                $this->outputInfo("Delete: " . $block->class);
                $block->delete();
                continue;
            }
            
            $newClassName = '\\' . $mappings[$originClassName] . '\\' . $originClassName;
            
            $this->outputInfo("Update from '{$block->class}' to '{$newClassName}'");
            
            $block->updateAttributes([
                'class' => $newClassName,
            ]);
        }
        
        $this->closeMigration(self::MIGRATION_CODE_100);
    }
    
    private function closeMigration($var)
    {
        Config::set($var, true);
        
        return $this->outputSuccess("Updater applied (code: {$var}). Now run the import command!");
    }
    
    public function actionVersions()
    {
        if (Config::has('luya_cmsadmin_updater_versions')) {
            return $this->outputError("You already have run the version updater, so your system should be up-to-date already.");
        }
        
        echo $this->outputInfo("Starting VERSIONS updater");
        
        foreach (NavItem::find()->all() as $item) {
            if ($item->nav_item_type !== NavItem::TYPE_PAGE) {
                echo $this->output('- Skip "' . $item->title . '" as its not a page type (module or redirect)');
                continue;
            }
            
            $typeModel = $item->getType();
            
            $typeModel->updateAttributes([
                'nav_item_id' => $item->id,
                'timestamp_create' => $item->timestamp_create,
                'create_user_id' => $item->create_user_id,
                'version_alias' => Module::VERSION_INIT_LABEL,
            ]);
            
            $this->outputSuccess('- updated: ' . $item->title);
        }
        
        Config::set('luya_cmsadmin_updater_versions', time());
        
        return $this->outputSuccess('We have successfully updated your version index.');
    }

    private $_classMapping = [
        '\cmsadmin' => '\luya\cms\frontend',
        '\bootstrap4' => '\luya\bootstrap4',
        '\gallery' => '\luya\gallery\admin',
        '\news' => '\luya\news\admin',
    ];
    
    public function actionClasses()
    {
        if (Config::has('rc1_block_classes_renameing')) {
            return $this->outputError("You already have run the classes updater, so your system should be up-to-date already.");
        }
        
        foreach (Block::find()->all() as $block) {
            $ns = $block->class;
            
            foreach ($this->_classMapping as $old => $new) {
                if (StringHelper::startsWith($ns, $old)) {
                    $this->outputError('old: ' . $ns);
                    
                    $newNs = StringHelper::replaceFirst($old, $new, $ns);
                    
                    $block->updateAttributes([
                        'class' => $newNs,
                    ]);
                    
                    $this->outputSuccess('new: ' . $newNs);
                }
            }
        }
        
        Config::set('rc1_block_classes_renameing', true);
        return $this->outputSuccess('OK. You can now run the import command.');
    }
}
