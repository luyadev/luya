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
use luya\admin\ngrest\render\RenderActiveWindow;
use luya\admin\ngrest\render\RenderActiveWindowCallback;
use luya\admin\ngrest\NgRest;

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
     * Unlock the useronline locker.
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

    /**
     * Search API.
     * 
     * This action is mainly used by  {{luya\admin\apis\SearchController}}.
     * 
     * @param unknown $query
     * @return unknown
     */
    public function actionSearch($query)
    {
        return $this->model->genericSearch($query);
    }

    /**
     * Search API Provider.
     * 
     * The searchProvider provides informations about how the admin UI can render the clickable links 
     * for the found results.
     * 
     * This action is mainly used by  {{luya\admin\apis\SearchController}} defined by {{luya\admin\base\GenericSearchInterface::genericSearchStateProvider}}
     * 
     * @return array
     */
    public function actionSearchProvider()
    {
        return $this->model->genericSearchStateProvider();
    }
    
    /**
     * Search API Hidden Fields
     * 
     * This action is mainly used by {luya\admin\apis\SearchController}}.
     * 
     * @return array
     */
    public function actionSearchHiddenFields()
    {
        return $this->model->genericSearchHiddenFields();
    }
    
    /**
     * Generate a response with pagination disabled.
     * 
     * Search querys with Pagination will be handled by this action.
     * 
     * @return \yii\data\ActiveDataProvider
     */
    public function actionFullResponse()
    {
        return new ActiveDataProvider([
            'query' => $this->model->find(),
            'pagination' => false,
        ]);
    }
    
    /**
     * Call the dataProvider for a foreign model.
     * 
     * @param unknown $arrayIndex
     * @param unknown $id
     * @param unknown $modelClass The name of the model where the ngRestRelation is defined.
     * @throws InvalidCallException
     * @return \yii\data\ActiveDataProvider
     */
    public function actionRelationCall($arrayIndex, $id, $modelClass)
    {
        $modelClass = base64_decode($modelClass);
        $model = $modelClass::findOne($id);
        
        if (!$model) {
            throw new InvalidCallException("unable to resolve relation call model.");
        }
        
        $query = $model->ngRestRelations()[$arrayIndex]['dataProvider'];
        
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }
    
    /**
     * Filter the Api response by a defined Filtername.
     * 
     * @param string $filterName
     * @throws InvalidCallException
     * @return \yii\data\ActiveDataProvider
     */
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
     * Renders the Callback for an ActiveWindow.
     * 
     * @return string
     */
    public function actionActiveWindowCallback()
    {
        $config = $this->model->getNgRestConfig();
        $render = new RenderActiveWindowCallback();
        $ngrest = new NgRest($config);
    
        return $ngrest->render($render);
    }
    
    /**
     * Renders the index page of an ActiveWindow.
     * 
     * @return string
     */
    public function actionActiveWindowRender()
    {
        $config = $this->model->getNgRestConfig();
        $render = new RenderActiveWindow();
        $render->setItemId(Yii::$app->request->post('itemId', false));
        $render->setActiveWindowHash(Yii::$app->request->post('activeWindowHash', false));
        $ngrest = new NgRest($config);
    
        return $ngrest->render($render);
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
        
        $menu = Yii::$app->adminmenu->getApiDetail($this->model->ngRestApiEndpoint());
        
        $route = $menu['route'];
        $route = str_replace("/index", "/export-download", $route);
        
        if ($store) {
            Yii::$app->session->set('tempNgRestFileName',  Inflector::slug($this->model->tableName())  . '-export-'.date("Y-m-d-H-i").'.csv');
            Yii::$app->session->set('tempNgRestFileMime',  'application/csv');
            Yii::$app->session->set('tempNgRestFileKey', $key);
            return [
                'url' => Url::toRoute(['/'.$route, 'key' => base64_encode($key)]),
            ];
        }
        
        throw new ErrorException("Unable to write the temporary file. Make sure the runtime folder is writeable.");
    }
}
