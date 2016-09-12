<?php

namespace luya\cms\admin\commands;

use luya\console\Command;
use luya\admin\models\Config;
use luya\cms\models\NavItem;
use luya\cms\admin\Module;
use luya\cms\models\Block;
use luya\helpers\StringHelper;

/**
 * This controller is part of the beta6 release and adds the version ability database migrations.
 *
 * @author nadar
 */
class UpdaterController extends Command
{
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
