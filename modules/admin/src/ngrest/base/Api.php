<?php

namespace admin\ngrest\base;

use Yii;
use luya\helpers\FileHelper;
use luya\helpers\Url;

/**
 * Wrapper for yii2 basic rest controller used with a model class. The wrapper is made to
 * change behaviours and overwrite the indexAction.
 *
 * usage like described in the yii2 guide.
 */
class Api extends \admin\base\RestActiveController
{
    public function actionServices()
    {
        return $this->model->getNgrestServices();
    }

    public function actionSearch($query)
    {
        if (strlen($query) <= 2) {
            Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');

            return ['query' => 'The query string must be at least 3 chars'];
        }
        return $this->model->genericSearch($query);
    }

    public function actionSearchProvider()
    {
        return $this->model->genericSearchStateProvider();
    }
    
    public function actionExport()
    {
    	$tempData = null;
    	foreach($this->model->find()->all() as $key => $value) {
    		$tempData.= $key . 'data';
    	}
    	
    	$key = uniqid('ngre', true);
    	
    	FileHelper::writeFile('@runtime/'.$key.'.tmp', $tempData);
    	
    	Yii::$app->session->set('tempNgRestKey', $key);
    	
    	return [
    		'url' => Url::toRoute(['/admin/ngrest/export-download', 'key' => base64_encode($key)]),
    	];
    }
}
