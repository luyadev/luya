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
        
        if (!$this->confirm("Warning: Have you made a Database Backup? If something goes wrong, the website content is unrecoverable lost!")) {
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
        foreach (Yii::$app->packageInstaller->configs as $config) {
            if ($config->package['name'] == "luyadev/luya-generic") {
                $genericExists = true;
            }
        }
        if (!$genericExists) {
            return $this->outputError("You have to register the luyadev/luya-generic package in your composer.json first and rerun the updater again afterwards.");
        }
        
        // change namespace from existing cms block to new generic block package.
        foreach (Block::find()->where(['like', 'class', '\\luya\\cms'])->all() as $block) {
            
            $genericClassName = str_replace("luya\\cms\\frontend\\", "luya\\generic\\", $block->class);
            
            $this->outputInfo("Update from '{$block->class}' to '{$genericClassName}'");
            
            $block->updateAttributes([
                'class' => $genericClassName,
            ]);
        }
        
        $this->closeMigration(self::MIGRATION_CODE_100);
    }
    
    private function closeMigration($var)
    {
        Config::set($var, true);
        
        return $this->outputSuccess("Migration has been applied successfull.");
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
