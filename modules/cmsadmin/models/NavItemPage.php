<?php

namespace cmsadmin\models;

use Yii;
use yii\db\Query;

class NavItemPage extends \cmsadmin\base\NavItemType
{
    private $_twig = null;

    public static function tableName()
    {
        return 'cms_nav_item_page';
    }

    public function rules()
    {
        return [
            [['layout_id'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'layout_id' => 'Layout',
        ];
    }

    private function getPlaceholders($navItemPageId, $placeholderVar, $prevId)
    {
        return (new Query())
        ->from('cms_nav_item_page_block_item t1')
        ->select('t1.*')
        ->where(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar, 'prev_id' => $prevId])
        ->orderBy('sort_index ASC')
        ->all();
    }

    private function getTwig()
    {
        if ($this->_twig === null) {
            $this->_twig = Yii::$app->twig->env(new \Twig_Loader_String());
        }

        return $this->_twig;
    }

    private function jsonToArray($json)
    {
        $response = json_decode($json, true);

        return (empty($response)) ? [] : $response;
    }

    public function getContent()
    {
        Yii::beginProfile('cmsContentBenchmark');
        
        $twig = Yii::$app->twig->env(new \Twig_Loader_Filesystem(Yii::getAlias('@app/views/cmslayouts/')));

        $insertion = [];

        foreach ($this->layout->getJsonConfig('placeholders') as $item) {
            $insertion[$item['var']] = $this->renderPlaceholder($this->id, $item['var'], 0);
        }

        $data = $twig->render($this->layout->view_file, [
            'placeholders' => $insertion,
            'activeUrl' => Yii::$app->menu->current->link, /* @todo remove: activeUrl already set via twig component ? */
        ]);
        
        Yii::endProfile('cmsContentBenchmark');
        
        return $data;
    }
    
    private function createHashKey($navItemPageId, $placeholderVar, $prevId)
    {
        return "$navItemPageId-$placeholderVar-$prevId";
    }
    
    private function setHasCache($key, $value, $expirationTime)
    {
        if (Yii::$app->has('cache')) {
            Yii::$app->cache->set($key, $value, $expirationTime);
        }
    }
    
    private function getHasCache($key)
    {
        if (Yii::$app->has('cache')) {
            $data = Yii::$app->cache->get($key);
            if ($data) {
                return $data;
            }
        }
        
        return false;
    }

    public function renderPlaceholder($navItemPageId, $placeholderVar, $prevId)
    {
        $string = '';

        foreach ($this->getPlaceholders($navItemPageId, $placeholderVar, $prevId) as $key => $placeholder) {
            
            $cacheKey = $this->createHashKey($placeholder['block_id'], $placeholder['id'], $prevId);
            
            $blockResponse = $this->getHasCache($cacheKey);
            
            if ($blockResponse === false) {
            
                // create block object
                $blockObject = Block::objectId($placeholder['block_id'], $placeholder['id'], 'frontend', $this->getNavItem());
                // see if its a valid block object
                if ($blockObject) {
                    if (count($blockObject->assets) > 0) {
                        $controllerObject = $this->getOption('cmsControllerObject');
                        if ($controllerObject) {
                            foreach ($blockObject->assets as $assetClassName) {
                                $controllerObject->registerAsset($assetClassName);
                            }
                        }
                    }
                    // insert var and cfg values from database
                    $blockObject->setVarValues($this->jsonToArray($placeholder['json_config_values']));
                    $blockObject->setCfgValues($this->jsonToArray($placeholder['json_config_cfg_values']));
                    // set env options from current object environment
                    foreach ($this->getOptions() as $optKey => $optValue) {
                        $blockObject->setEnvOption($optKey, $optValue);
                    }
                    // render sub placeholders and set into object
                    $insertedHolders = [];
                    foreach ($blockObject->getPlaceholders() as $item) {
                        $insertedHolders[$item['var']] = $this->renderPlaceholder($navItemPageId, $item['var'], $placeholder['id']);
                    }
                    $blockObject->setPlaceholderValues($insertedHolders);
                    // output buffer the rendered frontend string based on the current twig env
                    
                    $blockResponse = $blockObject->renderFrontend($this->getTwig());
                    
                    if ($blockObject->cacheEnabled) {
                        $this->setHasCache($cacheKey, $blockResponse, $blockObject->cacheExpiration);
                        //Yii::info($cacheKey . ": will be cached!");
                    } else {
                        //Yii::info($cacheKey. ": will NOT be cached!");
                    }
                }
            }
            
            $string.= $blockResponse;
        }

        return $string;
    }

    public function getLayout()
    {
        return $this->hasOne(\cmsadmin\models\Layout::className(), ['id' => 'layout_id']);
    }
}
