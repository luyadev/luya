<?php

namespace luya\admin\ngrest\base;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\Html;
use yii\base\InvalidCallException;
use yii\base\Arrayable;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use luya\helpers\FileHelper;
use luya\helpers\Url;
use luya\admin\base\RestActiveController;
use luya\admin\components\AdminUser;
use luya\admin\models\UserOnline;

/**
 * The RestActiveController for all NgRest implementations.
 *
 * @property \admin\ngrest\NgRestModeInterface $model Get the model object based on the $modelClass property.
 */
class Api extends RestActiveController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['view']['class'] = 'luya\admin\ngrest\base\actions\ViewAction';
        $actions['index']['class'] = 'luya\admin\ngrest\base\actions\IndexAction';
        $actions['create']['class'] = 'luya\admin\ngrest\base\actions\CreateAction';
        $actions['update']['class'] = 'luya\admin\ngrest\base\actions\UpdateAction';
        $actions['delete']['class'] = 'luya\admin\ngrest\base\actions\DeleteAction';
        return $actions;
    }
    
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
     * @var integer When pagination is enabled, this value is used for pagination rows by page.
     */
    public $pageSize = 100;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    
        if ($this->modelClass === null) {
            throw new InvalidConfigException("The property `modelClass` must be defined by the Controller.");
        }

        // pagination is disabled by default, lets verfy if there are more then 400 rows in the table and auto enable
        if ($this->pagination === false && $this->autoEnablePagination) {
            if ($this->model->ngRestFind()->count() > 200) {
                $this->pagination = ['pageSize' => $this->pageSize];
            }
        }
    }
    
    private $_model = null;
    
    /**
     * @return \luya\admin\ngrest\base\NgRestModel
     */
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject($this->modelClass);

            if (!$this->_model instanceof NgRestModelInterface) {
                throw new InvalidConfigException("The modelClass '$this->modelClass' must be an instance of NgRestModelInterface.");
            }
        }
    
        return $this->_model;
    }
    
    /**
     * Unlock the useronline locker..
     */
    public function actionUnlock()
    {
        UserOnline::unlock(Yii::$app->adminuser->id);
    }
    
    /**
     * Service Action provides mutliple CRUD informations.
     *
     * @return array
     */
    public function actionServices()
    {
        $settings = [];
        $apiEndpoint = $this->model->ngRestApiEndpoint();
        $userSortSettings = Yii::$app->adminuser->identity->setting->get('ngrestorder.admin/'.$apiEndpoint, false);
        
        if ($userSortSettings && is_array($userSortSettings)) {
            if ($userSortSettings['sort'] == SORT_DESC) {
                $order = '-'.$userSortSettings['field'];
            } else {
                $order = '+'.$userSortSettings['field'];
            }
            
            $settings['order'] = $order;
        }
        
        $userFilter = Yii::$app->adminuser->identity->setting->get('ngrestfilter.admin/'.$apiEndpoint, false);
        if ($userFilter) {
            $settings['filterName'] = $userFilter;
        }
        
        $modelClass = $this->modelClass;
        return [
            'service' => $this->model->getNgrestServices(),
            '_settings' => $settings,
            '_locked' => [
                'data' => UserOnline::find()->select(['lock_pk', 'last_timestamp', 'u.firstname', 'u.lastname', 'u.id'])->joinWith('user as u')->where(['lock_table' => $modelClass::tableName()])->createCommand()->queryAll(),
                'userId' => Yii::$app->adminuser->id,
            ],
        ];
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
    
    public function actionRelationCall($arrayIndex, $id, $modelClass)
    {
        $modelClass = base64_decode($modelClass);
        $model = $modelClass::findOne($id);
        
        if (!$model) {
            throw new InvalidCallException("unable to resolve relation call model.");
        }
        
        $func = $model->ngRestRelations()[$arrayIndex]['dataProvider'];
        
        return new ActiveDataProvider([
            'query' => $func,
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
