<?php

namespace luya\admin\ngrest\render;

use Yii;
use luya\admin\components\Auth;
use luya\admin\models\Lang;
use luya\admin\ngrest\NgRest;
use luya\admin\ngrest\base\Render;
use yii\base\InvalidConfigException;
use yii\base\ViewContextInterface;
use luya\helpers\Html;
use luya\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Render the Crud view.
 *
 * @property \luya\admin\ngrest\render\RenderCrudView $view
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RenderCrud extends Render implements RenderInterface, ViewContextInterface, RenderCrudInterface
{
    const TYPE_LIST = 'list';

    const TYPE_CREATE = 'create';

    const TYPE_UPDATE = 'update';

    private $_view;

    /**
     * Returns the current view object.
     *
     * @return \luya\admin\ngrest\render\RenderCrudView
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new RenderCrudView();
        }

        return $this->_view;
    }
    
    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return '@admin/views/ngrest';
    }
    
    /**
     * @inheritdoc
     */
    public function render()
    {
        return $this->view->render('crud', [
            'canCreate' => $this->can(Auth::CAN_CREATE),
            'canUpdate' => $this->can(Auth::CAN_UPDATE),
            'canDelete' => $this->can(Auth::CAN_DELETE),
            'config' => $this->config,
            'isInline' => $this->getIsInline(),
            'modelSelection' => $this->getModelSelection(),
            'relationCall' => $this->getRelationCall(), // this is currently only used for the curd_relation view file, there for split the RenderCrud into two sepeare renderes.
            'currentMenu' => Yii::$app->adminmenu->getApiDetail($this->getConfig()->getApiEndpoint()),
        ], $this);
    }

    // RenderCrudInterface
    
    private $_relationCall = false;
    
    /**
     * @inheritdoc
     */
    public function getRelationCall()
    {
        return $this->_relationCall;
    }
    
    /**
     * @inheritdoc
     */
    public function setRelationCall(array $options)
    {
        $this->_relationCall = $options;
    }
    
    private $_isInline = false;

    /**
     * @inheritdoc
     */
    public function getIsInline()
    {
        return $this->_isInline;
    }
    
    /**
     * @inheritdoc
     */
    public function setIsInline($inline)
    {
        $this->_isInline = $inline;
    }
    
    private $_modelSelection;
    
    /**
     * @inheritdoc
     */
    public function setModelSelection($selection)
    {
        $this->_modelSelection = $selection;
    }
    
    /**
     * @inheritdoc
     */
    public function getModelSelection()
    {
        return $this->_modelSelection;
    }
    
    private $_settingButtonDefinitions = [];
    
    /**
     * @inheritdoc
     */
    public function setSettingButtonDefinitions(array $buttons)
    {
        $elements = [];
        foreach ($buttons as $config) {
            $innerContent = '<i class="material-icons">' . ArrayHelper::getValue($config, 'icon', 'extension') .'</i><span> '. $config['label'] . '</span>';
            
            $tagName = ArrayHelper::remove($config, 'tag', 'a');
            
            if (!array_key_exists('class', $config)) {
                $config['class'] = 'dropdown-item';
            }
            
            $elements[] = Html::tag($tagName, $innerContent, $config);
        }
        
        $this->_settingButtonDefinitions= $elements;
    }

    /**
     * @inheritdoc
     */
    public function getSettingButtonDefinitions()
    {
        return $this->_settingButtonDefinitions;
    }
    
    // methods used inside the view context: RenderCrudView
    
    /**
     * Returns the current order by state.
     *
     * @return string angular order by statements like `+id` or `-name`.
     */
    public function getOrderBy()
    {
        if ($this->getConfig()->getDefaultOrderField() === false) {
            return false;
        }
        
        return $this->getConfig()->getDefaultOrderDirection() . $this->getConfig()->getDefaultOrderField();
    }
    
    /**
     * Returns the primary key from the config.
     *
     * @return unknown
     */
    public function getPrimaryKey()
    {
        return implode(",", $this->config->getPrimaryKey());
    }
    
    /**
     * Returns the api endpoint, but can add appendix.
     *
     * @return string
     */
    public function getApiEndpoint($append = null)
    {
        if ($append) {
            $append = '/' . ltrim($append, '/');
        }
        
        return 'admin/'.$this->getConfig()->getApiEndpoint() . $append;
    }
    
    // generic methods
    
    private $_canTypes = [];
    
    /**
     * Checks whether a given type can or can not.
     *
     * @param string $type
     * @return boolean
     */
    protected function can($type)
    {
        if (!array_key_exists($type, $this->_canTypes)) {
            $this->_canTypes[$type] = Yii::$app->auth->matchApi(Yii::$app->adminuser->getId(), $this->config->apiEndpoint, $type);
        }
        
        return $this->_canTypes[$type];
    }
    
    /**
     *
     * @param unknown $modelPrefix In common case its `item`.
     */
    public function getCompositionKeysForButtonActions($modelPrefix)
    {
        $output = [];
        foreach ($this->config->getPrimaryKey() as $key) {
            $output[] = $modelPrefix . '.' . $key;
        }
        
        return "[". implode(",", $output) . "]";
    }
    
    /*
     * OLD
     */

    private $_buttons;
    
    /**
     * collection all the buttons in the crud list.
     *
     * each items required the following keys (ngClick, icon, label):
     *
     * ```php
     * return [
     *     ['ngClick' => 'toggle(...)', 'icon' => 'fa fa-fw fa-edit', 'label' => 'Button Label']
     * ];
     * ```
     * @return returns array with all buttons for this crud
     * @throws InvalidConfigException
     */
    public function getButtons()
    {
        if ($this->_buttons === null) {
            $buttons = [];
            
            
            foreach ($this->getConfig()->getRelations() as $rel) {
                $api = Yii::$app->adminmenu->getApiDetail($rel['apiEndpoint']);
                
                if (!$api) {
                    throw new InvalidConfigException("The configured api relation '{$rel['apiEndpoint']}' does not exists in the menu elements. Maybe you have no permissions to access this API.");
                }
                
                $label = empty($rel['tabLabelAttribute']) ? "'{$rel['label']}'" : 'item.'.$rel['tabLabelAttribute'];
                
                $buttons[] = [
                    'ngClick' => 'addAndswitchToTab(item.'.$this->getPrimaryKey().', \''.$api['route'].'\', \''.$rel['arrayIndex'].'\', '.$label.', \''.$rel['modelClass'].'\')',
                    'icon' => 'chrome_reader_mode',
                    'label' => $rel['label'],
                ];
            }
            
            if ($this->can(Auth::CAN_UPDATE)) {
                // get all activeWindows assign to the crud
                foreach ($this->getActiveWindows() as $hash => $config) {
                    $buttons[] = [
                        'ngClick' => 'getActiveWindow(\''.$hash.'\', '.$this->getCompositionKeysForButtonActions('item').')',
                        'icon' => $config['icon'],
                        'label' => $config['label'],
                    ];
                }
            }
            
            // check if deletable is enabled
            if ($this->config->isDeletable() && $this->can(Auth::CAN_DELETE)) {
                $buttons[] = [
                    'ngClick' => 'deleteItem('.$this->getCompositionKeysForButtonActions('item').')',
                    'icon' => 'delete',
                    'label' => '',
                ];
            }
            // do we have an edit button
            if (count($this->getFields('update')) > 0 && $this->can(Auth::CAN_UPDATE)) {
                $buttons[] = [
                    'ngClick' => 'toggleUpdate('.$this->getCompositionKeysForButtonActions('item').')',
                    'icon' => 'mode_edit',
                    'label' => '',
                ];
            }
            
            $this->_buttons = $buttons;
        }

        return $this->_buttons;
    }

    public function apiQueryString($type)
    {
        // basic query
        $query = ['ngrestCallType' => $type];
        // see if we have fields for this type
        if (count($this->getFields($type)) > 0) {
            $query['fields'] = implode(',', $this->getFields($type));
        }
        // doe we have extra fields to expand
        if (count($this->config->getPointerExtraFields($type)) > 0) {
            $query['expand'] = implode(',', $this->config->getPointerExtraFields($type));
        }
        // return url decoed string from http_build_query
        return http_build_query($query, '', '&');
    }

    private $_fields = [];
    
    /**
     * wrapper of $config->getPointer to get only the fields.
     */
    public function getFields($type)
    {
        if (!array_key_exists($type, $this->_fields)) {
            $fields = [];
            if ($this->config->hasPointer($type)) {
                foreach ($this->config->getPointer($type) as $item) {
                    $fields[] = $item['name'];
                }
            }

            $this->_fields[$type] = $fields;
        }

        return $this->_fields[$type];
    }

    public function getFieldsJson($type)
    {
        return json_encode($this->getFields($type));
    }

    public function getActiveWindows()
    {
        return ($activeWindows = $this->config->getPointer('aw')) ? $activeWindows : [];
    }
    
    
    private $_langs;

    public function getLangs()
    {
        if ($this->_langs === null) {
            $this->_langs = Lang::getQuery();
        }

        return $this->_langs;
    }

    private $_defaultLangShortCode;

    public function getDefaultLangShortCode()
    {
        if ($this->_defaultLangShortCode === null) {
            $lang = Lang::getDefault();
            $this->_defaultLangShortCode = $lang['short_code'];
        }

        return $this->_defaultLangShortCode;
    }

    private function evalGroupFields($pointerElements)
    {
        if (!$pointerElements) {
            return [];
        }
        
        $names = [];
        foreach ($pointerElements as $elmn) {
            $names[$elmn['name']] = $elmn['name'];
        }
        
        foreach ($this->getConfig()->getAttributeGroups()as $group) {
            foreach ($group[0] as $item) {
                if (in_array($item, $names)) {
                    unset($names[$item]);
                }
            }
        }
        
        $groups[] = [$names, '__default', 'collapsed' => true, 'is_default' => true];
        
        
        return array_merge($groups, $this->getConfig()->getAttributeGroups());
    }
    
    public function forEachGroups($pointer)
    {
        $groups = $this->evalGroupFields($this->config->getPointer($pointer));

        $data = [];
        
        foreach ($groups as $group) {
            $data[] = [
                'fields' => $this->config->getFields($pointer, $group[0]),
                'name' => $group[1],
                'collapsed' => (isset($group['collapsed'])) ? (bool) $group['collapsed'] : false,
                'is_default' => (isset($group['is_default'])) ? (bool) $group['is_default'] : false,
            ];
        }
        
        return $data;
    }

    /**
     * Create element for given element and config pointer context.
     *
     * @param unknown_type $element
     * @param string $configContext list,create,update
     * @return array
     */
    public function createElements($element, $configContext)
    {
        if ($element['i18n'] && $configContext !== self::TYPE_LIST) {
            $i = 0;
            $return = [];
            foreach ($this->getLangs() as $lang) {
                if ($i == 0) {
                    $return[] = [
                        'html' => '<div class="form-i18n" ng-class="{\'has-field-help\': getFieldHelp(\''.$element['name'].'\')}">
                                       ' . $this->createFieldHelpButton($element, $configContext) . '
                                       <label class="form-i18n-label">
                                        ' . $element['alias'] . '
                                       </label>
                                           <div class="row">',
                    ];
                }
                $ngModel = $this->i18nNgModelString($configContext, $element['name'], $lang['short_code']);
                $id = 'id-'.md5($ngModel.$lang['short_code']);
                // anzahl cols durch anzahl sprachen
                $return[] = [
                    'html' => '<div class="col" ng-show="AdminLangService.isInSelection(\''.$lang['short_code'].'\')">'.$this->renderElementPlugins($configContext, $element['type'], $id, $element['name'], $ngModel, $element['alias'], true).'<span class="flag flag-'.$lang['short_code'].' form-col-flag"><span class="flag-fallback">'.$lang['short_code'].'</span></span></div>',
                ];

                ++$i;
            }
            $return[] = ['html' => '</div><!-- /row --> </div><!-- /i18n -->'];

            return $return;
        }

        $ngModel = $this->ngModelString($configContext, $element['name']);
        $id = 'id-'.md5($ngModel);

        return [
            [
                'html' => $this->createFieldHelpButton($element, $configContext) . $this->renderElementPlugins($configContext, $element['type'], $id, $element['name'], $ngModel, $element['alias'], false),
            ],
        ];
    }

    private function createFieldHelpButton(array $element, $configContext)
    {
        if ($configContext !== self::TYPE_LIST) {
            return '<span ng-if="getFieldHelp(\''.$element['name'].'\')" class="help-button btn btn-icon btn-help" tooltip tooltip-expression="getFieldHelp(\''.$element['name'].'\')" tooltip-position="left"></span>';
        }
    }
    
    private function renderElementPlugins($configContext, $typeConfig, $elmnId, $elmnName, $elmnModel, $elmnAlias, $elmni18n)
    {
        $obj = NgRest::createPluginObject($typeConfig['class'], $elmnName, $elmnAlias, $elmni18n, $typeConfig['args']);
        $method = 'render'.ucfirst($configContext);
        $html = $obj->$method($elmnId, $elmnModel);

        return is_array($html) ? implode(" ", $html) : $html;
    }

    public function ngModelString($configContext, $fieldId)
    {
        return ($configContext == self::TYPE_LIST) ? 'item.'.$fieldId : 'data.'.$configContext.'.'.$fieldId;
    }

    private function i18nNgModelString($configContext, $fieldId, $lang)
    {
        return 'data.'.$configContext.'.'.$fieldId.'[\''.$lang.'\']';
    }
}
