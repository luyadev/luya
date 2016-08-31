<?php

namespace cmsadmin\commands;

use luya\console\Command;
use luya\admin\models\Config;
use luya\cms\models\NavItem;
use luya\cms\admin\Module;

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
}
