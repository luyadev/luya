<?php

namespace admin\ngrest\base;

use Yii;
use luya\helpers\FileHelper;
use luya\helpers\Url;
use yii\helpers\Inflector;
use yii\base\InvalidCallException;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

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
    
    public function actionFilter($filterName)
    {
        $model = $this->model;
        
        $filterName = Html::encode($filterName);
        
        if (!array_key_exists($filterName, $model->filters())) {
            throw new InvalidCallException("The requested filter does not exists in the filter list.");
        }

        return new ActiveDataProvider([
            'query' => $model->filters()[$filterName],
        ]);
    }
    
    /**
     * Prepare a temp file to
     * @todo added very basic csv support, must be stored as class, just a temp solution
     * @return array
     */
    public function actionExport()
    {
    	$tempData = null;
    	
    	// first row
    	$header = [];
    	$i = 0;
    	
    	foreach($this->model->find()->all() as $key => $value) {
    	    
    	    $row = [];
    	    foreach ($value->getAttributes() as $k => $v) {
    	        
    	        if (is_object($v)) {
    	            continue;
    	        }
    	        
    	        if ($i === 0) {
    	             $header[] = $this->model->getAttributeLabel($k);
    	        }
    	        
    	        if (is_array($v)) {
    	            $v = implode(",", $v);
    	        }
    	        
    	        $row[] = '"'. str_replace('"', '\"', $v) .'"';
    	    }
    	    
    	    
    	    if ($i=== 0) {
    	        $tempData.= implode(",", $header) . "\n";
    	    }
    	    $tempData.= implode(",", $row) . "\n";
    	    $i++;
    	}
    	
    	$key = uniqid('ngre', true);
    	
    	FileHelper::writeFile('@runtime/'.$key.'.tmp', $tempData);
    	
    	Yii::$app->session->set('tempNgRestFileName', Inflector::slug($this->model->tableName()));
    	Yii::$app->session->set('tempNgRestKey', $key);
    	
    	return [
    		'url' => Url::toRoute(['/admin/ngrest/export-download', 'key' => base64_encode($key)]),
    	];
    }
}
