<?php

namespace luya\admin\ngrest\base;

use Yii;
use luya\helpers\FileHelper;
use luya\helpers\Url;
use yii\helpers\Inflector;
use yii\base\InvalidCallException;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\base\Arrayable;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use luya\admin\base\RestActiveController;
use luya\helpers\ArrayHelper;

/**
 * The RestActiveController for all NgRest implementations.
 *
 * @property \admin\ngrest\NgRestModeInterface $model Get the model object based on the $modelClass property.
 */
class Api extends RestActiveController
{
    /**
     * @var string Defines the related model for the NgRest Controller. The full qualiefied model name
     * is required.
     *
     * ```php
     * public $modelClass = 'admin\models\User';
     * ```
     */
    public $modelClass = null;
    
    /**
     * @var boolean Defines whether the automatic pagination should be enabled if more then 200 rows of data stored in this table or not.
     */
    public $autoEnablePagination = true;
    
    /**
     * {@inheritDoc}
     * @see \yii\rest\ActiveController::init()
     */
    public function init()
    {
        parent::init();
    
        if ($this->modelClass === null) {
            throw new InvalidConfigException("The property `modelClass` must be defined by the Controller.");
        }

        // pagination is disabled by default, lets verfy if there are more then 400 rows in the table and auto enable
        if ($this->pagination === false && $this->autoEnablePagination) {
            if ($this->model->find()->count() > 200) {
                $this->pagination = ['pageSize' => 100];
            }
        }
    }
    
    private $_model = null;
    
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject($this->modelClass);
        }
    
        return $this->_model;
    }
    
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
    
    public function actionFullResponse()
    {
        return new ActiveDataProvider([
            'query' => $this->model->find(),
            'pagination' => false,
        ]);
    }
    
    public function actionFilter($filterName)
    {
        $model = $this->model;
        
        $filterName = Html::encode($filterName);
        
        if (!array_key_exists($filterName, $model->ngRestFilters())) {
            throw new InvalidCallException("The requested filter does not exists in the filter list.");
        }

        return new ActiveDataProvider([
            'query' => $model->ngRestFilters()[$filterName],
            'pagination' => $this->pagination,
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
        
        foreach ($this->model->find()->all() as $key => $value) {
            $row = [];
            
            $attrs = $value->getAttributes();
            foreach ($value->extraFields() as $field) {
                $attrs[$field] = $value->$field;
            }
            
            foreach ($attrs as $k => $v) {
                if (is_object($v)) {
                    if ($v instanceof Arrayable) {
                        $v = $v->toArray();
                    } else {
                        continue;
                    }
                }
                
                if ($i === 0) {
                    $header[] = $this->model->getAttributeLabel($k);
                }
                
                if (is_array($v)) {
                    $tv = [];
                    foreach ($v as $kk => $vv) {
                        if (is_object($vv)) {
                            if ($vv instanceof Arrayable) {
                                $tv[] = implode(" | ", $vv->toArray());
                            } else {
                                continue;
                            }
                        } elseif (is_array($vv)) {
                            $tv[] = implode(" | ", $vv);
                        } else {
                            $tv[] = $vv;
                        }
                    }
                 
                    $v = implode(" - ", $tv);
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
        
        $store = FileHelper::writeFile('@runtime/'.$key.'.tmp', $tempData);
        
        if ($store) {
            Yii::$app->session->set('tempNgRestFileName', Inflector::slug($this->model->tableName()));
            Yii::$app->session->set('tempNgRestKey', $key);
            return [
                'url' => Url::toRoute(['/admin/ngrest/export-download', 'key' => base64_encode($key)]),
            ];
        }
        
        throw new ErrorException("Unable to write the temporary file for the csv export. Make sure the runtime folder is writeable.");
    }
}
