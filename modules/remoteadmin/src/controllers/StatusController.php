<?php

namespace luya\remoteadmin\controllers;

use luya\remoteadmin\models\Site;
use luya\traits\CacheableTrait;

/**
 * @see packages api https://packagist.org/apidoc
 * @author Basil Suter <basil@nadar.io>
 */
class StatusController extends \luya\admin\base\Controller
{
	use CacheableTrait;
	
    public function actionIndex()
    {
        return $this->renderPartial('index', [
            'sites' => Site::find()->all(),
        	'currentVersion' => Site::getCurrentLuyaVersion(),
        ]);
    }
}
