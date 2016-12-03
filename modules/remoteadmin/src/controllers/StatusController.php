<?php

namespace luya\remoteadmin\controllers;

use yii\helpers\Json;
use luya\remoteadmin\models\Site;

/**
 * @see packages api https://packagist.org/apidoc
 * @author Basil Suter <basil@nadar.io>
 */
class StatusController extends \luya\admin\base\Controller
{
    public $current = null;
    
    public function actionIndex()
    {
        $sites = [];
        foreach (Site::find()->all() as $site) {
            $sites[] = [
                'data' => $site->toArray(),
                'remote' => $site->getRemote(),
            ];
        }
        
        $curl = new \Curl\Curl();
        
        $curl->get('https://packagist.org/packages/luyadev/luya-core.json');
        $json = Json::decode($curl->response);
        
        foreach ($json['package']['versions'] as $version =>  $package) {
            if ($version == 'dev-master' || !is_numeric(substr($version, 0, 1))) {
                continue;
            }
            
            $this->current = $package;
            break;
        }
        
        return $this->renderPartial('index', [
            'sites' => $sites,
            'currentVersion' => $this->current,
        ]);
    }
    
    public function textify($value)
    {
        return ($value) ? 'On' : 'Off';
    }
    
    public function colorize($value)
    {
        return ($value) ? 'style="background-color:#c8e6c9;"' : 'style="background-color:#ffcdd2;";';
    }
    
    public function versionize($version)
    {
        return ($version == $this->current['version']) ? 'style="background-color:#c8e6c9;"' : 'style="background-color:#ffcdd2;";';
    }
}
