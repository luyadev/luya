<?php

namespace luya\cms\models;

use Yii;
use yii\db\Query;
use luya\Exception;
use luya\web\View;
use luya\cms\models\NavItemPageBlockItem;
use luya\cms\base\NavItemType;
use luya\cms\base\NavItemTypeInterface;
use luya\cms\admin\Module;
use luya\traits\CacheableTrait;

/**
 * Represents the type PAGE for a NavItem.
 *
 * @property integer $id
 * @property integer $layout_id
 * @property integer $nav_item_id
 * @property integer $timestamp_create
 * @property integer $create_user_id
 * @property string $version_alias
 *
 * @author Basil Suter <basil@nadar.io>
 */
class NavItemPage extends NavItemType implements NavItemTypeInterface
{
    use CacheableTrait;

    private $_view = null;

    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_AFTER_DELETE, function ($event) {
            foreach ($event->sender->navItemPageBlockItems as $item) {
                $item->delete();
            }
            
            $event->sender->forceNavItem->updateTimestamp();
        });
        
        $this->on(self::EVENT_AFTER_UPDATE, function ($event) {
            $event->sender->forceNavItem->updateTimestamp();
        });
    }

    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new View();
        }
        
        return $this->_view;
    }
    
    /**
     * {@InheritDoc}
     * @see \luya\cms\base\NavItemType::getNumericType()
     */
    public static function getNummericType()
    {
        return NavItem::TYPE_PAGE;
    }
    
    public static function tableName()
    {
        return 'cms_nav_item_page';
    }

    public function rules()
    {
        return [
            [['layout_id', 'timestamp_create', 'create_user_id'], 'required'],
            [['nav_item_id', 'timestamp_create', 'create_user_id'], 'integer'],
            [['version_alias'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'layout_id' => Module::t('model_navitempage_layout_label'),
        ];
    }
    
    public function getLayout()
    {
        return $this->hasOne(Layout::className(), ['id' => 'layout_id']);
    }
    
    public function extraFields()
    {
        return [
            'content_as_array' => 'contentAsArray',
        ];
    }
    
    /**
     * Get the list of version/pages for a specific nav item id
     *
     * @param unknown $navItemId
     */
    public static function getVersionList($navItemId)
    {
        return self::find()->where(['nav_item_id' => $navItemId])->indexBy('id')->orderBy(['id' => SORT_ASC])->all();
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['contentAsArray'] = 'contentAsArray';
        $fields['version_alias'] = function ($model) {
            return Module::t($model->version_alias);
        };
        return $fields;
    }
    
    /**
     * Frontend get Content returns the rendered content for this nav item page based on the page logic (placeholders, blocks)
     *
     * {@inheritDoc}
     * @see \luya\cms\base\NavItemType::getContent()
     */
    public function getContent()
    {
        if ($this->layout) {
            $layoutFile = Yii::getAlias('@app/views/cmslayouts/' . $this->layout->view_file);
            $placholders = [];
            foreach ($this->layout->getJsonConfig('placeholders') as $item) {
                $placholders[$item['var']] = $this->renderPlaceholder($item['var']);
            }
            return $this->getView()->renderPhpFile($layoutFile, ['placeholders' => $placholders]);
        }
        
        throw new Exception("Could not find the requested cms layout id '".$this->layout_id."' for nav item page id '". $this->id . "'. Make sure your page does not have an old inactive/deleted cms layout selected.");
    }

    /**
     * Render as the cmslayout placeholder for this model page.
     *
     * If we assume you have a placeholder variable `foobar` in the cmslayout for this page:
     *
     * ```php
     * <div>
     *     <?= $placeholders['foobar']; ?>
     * </div>
     * ```
     *
     * You can access the content of foobar with
     *
     * ```php
     * return Nav::findOne(ID_OF_THE_PAGE)->activeLanguageItem->type->renderPlaceholder('content'));
     * ```
     *
     * @param string $placeholderName The Cmslayout placeholder identifier
     * @return string
     */
    public function renderPlaceholder($placeholderName)
    {
        return $this->renderPlaceholderRecursive($this->id, $placeholderName, 0);
    }
    
    private function renderPlaceholderRecursive($navItemPageId, $placeholderVar, $prevId)
    {
        $string = '';
        $i = 0;
        $placeholders = $this->getPlaceholders($navItemPageId, $placeholderVar, $prevId);
        $blocksCount = count($placeholders);
        // foreach all placeholders but preserve varaibles above to make calculations
        foreach ($placeholders as $key => $placeholder) {
            $i++;
            $prev = $key-1;
            $next = $key+1;
            $cacheKey = ['blockcache', (int) $placeholder['id']];
            
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
                    
                    $blockObject->setEnvOption('index', $i);
                    $blockObject->setEnvOption('itemsCount', $blocksCount);
                    $blockObject->setEnvOption('isFirst', ($i == 1));
                    $blockObject->setEnvOption('isLast', ($i == $blocksCount));
                    $blockObject->setEnvOption('isPrevEqual', array_key_exists($prev, $placeholders) && $placeholder['block_id'] == $placeholders[$prev]['block_id']);
                    $blockObject->setEnvOption('isNextEqual', array_key_exists($next, $placeholders) && $placeholder['block_id'] == $placeholders[$next]['block_id']);
                    // render sub placeholders and set into object
                    $insertedHolders = [];
                    foreach ($blockObject->getPlaceholders() as $item) {
                        $insertedHolders[$item['var']] = $this->renderPlaceholderRecursive($navItemPageId, $item['var'], $placeholder['id']);
                    }
                    $blockObject->setPlaceholderValues($insertedHolders);
                    // output buffer the rendered frontend method of the block
                    $blockResponse = $blockObject->renderFrontend();
                    
                    if ($blockObject->cacheEnabled) {
                        $this->setHasCache($cacheKey, $blockResponse, null, $blockObject->cacheExpiration);
                    }
                }
            }
            
            $string.= $blockResponse;
        }

        return $string;
    }

    private function getPlaceholders($navItemPageId, $placeholderVar, $prevId)
    {
        return (new Query())
        ->from('cms_nav_item_page_block_item t1')
        ->select('t1.*')
        ->where(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar, 'prev_id' => $prevId, 'is_hidden' => 0])
        ->orderBy('sort_index ASC')
        ->all();
    }
    
    private function jsonToArray($json)
    {
        $response = json_decode($json, true);
    
        return (empty($response)) ? [] : $response;
    }
    
    // ajax parts to get the tree moved from the controller to the model in version beta 6

    /**
     * Get the full array content from all the blocks, placeholders, vars configs and values recursiv for this current NavItemPage (which is layout version for a nav item)
     * @return array
     */
    public function getContentAsArray()
    {
        $nav_item_page = (new \yii\db\Query())->select('*')->from('cms_nav_item_page t1')->leftJoin('cms_layout', 'cms_layout.id=t1.layout_id')->where(['t1.id' => $this->id])->one();
        
        $return = [
                'nav_item_page' => ['id' => $nav_item_page['id'], 'layout_id' => $nav_item_page['layout_id'], 'layout_name' => $nav_item_page['name']],
                '__placeholders' => [],
            ];
        
        $nav_item_page['json_config'] = json_decode($nav_item_page['json_config'], true);
        
        if (isset($nav_item_page['json_config']['placeholders'])) {
            foreach ($nav_item_page['json_config']['placeholders'] as $placeholderKey => $placeholder) {
                $placeholder['nav_item_page_id'] = $this->id;
                $placeholder['prev_id'] = 0;
                $placeholder['__nav_item_page_block_items'] = [];
        
                $return['__placeholders'][$placeholderKey] = $placeholder;
        
                $placeholderVar = $placeholder['var'];
        
                $return['__placeholders'][$placeholderKey]['__nav_item_page_block_items'] = self::getPlaceholder($placeholderVar, $this->id, 0);
            }
        }
        
        return $return;
    }
    
    public static function getPlaceholder($placeholderVar, $navItemPageId, $prevId)
    {
        /*
         $nav_item_page_block_item_data = (new \yii\db\Query())->select([
         't1_id' => 't1.id', 't1.is_dirty', 'block_id', 't1_nav_item_page_id' => 't1.nav_item_page_id', 't1_json_config_values' => 't1.json_config_values', 't1_json_config_cfg_values' => 't1.json_config_cfg_values', 't1_placeholder_var' => 't1.placeholder_var', 't1_prev_id' => 't1.prev_id',
         //'t2_id' => 't2.id', 't2_name' => 't2.name', 't2_json_config' => 't2.json_config', 't2_twig_admin' => 't2.twig_admin',
         ])->from('cms_nav_item_page_block_item t1')->orderBy('t1.sort_index ASC')->where(['t1.prev_id' => $prevId, 't1.nav_item_page_id' => $navItemPageId, 't1.placeholder_var' => $placeholderVar])->all();
         */
    
        $nav_item_page_block_item_data = (new \yii\db\Query())->select(['id'])->from('cms_nav_item_page_block_item')->orderBy('sort_index ASC')->where(['prev_id' => $prevId, 'nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar])->all();
    
        $data = [];
    
        foreach ($nav_item_page_block_item_data as $blockItem) {
            $block = static::getBlock($blockItem['id']);
            if ($block) {
                $data[] = $block;
            }
        }
    
        return $data;
    }
    
    public static function getBlock($blockId)
    {
        $blockItem = (new Query())->select('*')->from('cms_nav_item_page_block_item')->where(['id' => $blockId])->one();
    
        $blockObject = Block::objectId($blockItem['block_id'], $blockItem['id'], 'admin', NavItem::findOne($blockItem['nav_item_page_id']));
        if ($blockObject === false) {
            return false;
        }
    
        $blockItem['json_config_values'] = json_decode($blockItem['json_config_values'], true);
        $blockItem['json_config_cfg_values'] = json_decode($blockItem['json_config_cfg_values'], true);
    
        $blockValue = $blockItem['json_config_values'];
        $blockCfgValue = $blockItem['json_config_cfg_values'];
    
        $blockObject->setVarValues((empty($blockValue)) ? [] : $blockValue);
        $blockObject->setCfgValues((empty($blockCfgValue)) ? [] : $blockCfgValue);
    
        $placeholders = [];
    
        foreach ($blockObject->getPlaceholders() as $pk => $pv) {
            $pv['nav_item_page_id'] = $blockItem['nav_item_page_id'];
            $pv['prev_id'] = $blockItem['id'];
            $placeholderVar = $pv['var'];
    
            $pv['__nav_item_page_block_items'] = static::getPlaceholder($placeholderVar, $blockItem['nav_item_page_id'], $blockItem['id']);
    
            $placeholder = $pv;
    
            $placeholders[] = $placeholder;
        }
    
        if (empty($blockItem['json_config_values'])) {
            $blockItem['json_config_values'] = ['__e' => '__o'];
        }
    
        if (empty($blockItem['json_config_cfg_values'])) {
            $blockItem['json_config_cfg_values'] = ['__e' => '__o'];
        }
    
        return [
            'is_dirty' => (int) $blockItem['is_dirty'],
            'is_container' => (int) $blockObject->isContainer,
            'id' => $blockItem['id'],
            'is_hidden' => $blockItem['is_hidden'],
            'name' => $blockObject->name(),
            'icon' => $blockObject->icon(),
            'full_name' => $blockObject->getFullName(),
            'twig_admin' => $blockObject->renderAdmin(),
            'vars' => $blockObject->getVars(),
            'cfgs' => $blockObject->getCfgs(),
            'extras' => $blockObject->extraVarsOutput(),
            'values' => $blockItem['json_config_values'],
            'field_help' => $blockObject->getFieldHelp(),
            'cfgvalues' => $blockItem['json_config_cfg_values'], // add: t1_json_config_cfg_values
            '__placeholders' => $placeholders,
        ];
    }
    
    public static function copyBlocks($fromPageId, $toPageId)
    {
        $pageBlocks = NavItemPageBlockItem::findAll(['nav_item_page_id' => $fromPageId]);
        
        $idLink = [];
        foreach ($pageBlocks as $block) {
            $blockItem = new NavItemPageBlockItem();
            $blockItem->attributes = $block->toArray();
            $blockItem->nav_item_page_id = $toPageId;
            $blockItem->insert();
            $idLink[$block->id] = $blockItem->id;
        }
        // check if prev_id is used, check if id is in set - get new id and set new prev_ids in copied items
        $newPageBlocks = NavItemPageBlockItem::findAll(['nav_item_page_id' => $toPageId]);
        foreach ($newPageBlocks as $block) {
            if ($block->prev_id) {
                if (isset($idLink[$block->prev_id])) {
                    $block->prev_id = $idLink[$block->prev_id];
                }
            }
            $block->update(false);
        }
        
        return true;
    }
    
    /**
     * This method is used to force the parent nav item for the corresponding page item. The default
     * implemenation `getNavItem` works the invert way.
     *
     * @return \luya\cms\models\NavItem
     */
    public function getForceNavItem()
    {
        return NavItem::findOne($this->nav_item_id);
    }
    
    /**
     * Return all page block items for the current corresponding page. Not related to any sortings or placeholders.
     *
     * @return ActiveQuery
     */
    public function getNavItemPageBlockItems()
    {
        return $this->hasMany(NavItemPageBlockItem::className(), ['nav_item_page_id' => 'id']);
    }
}
