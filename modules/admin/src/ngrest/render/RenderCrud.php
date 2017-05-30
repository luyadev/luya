<?php

namespace luya\admin\ngrest\render;

use Yii;
use luya\admin\components\Auth;
use luya\admin\models\Lang;
use luya\admin\ngrest\NgRest;
use luya\admin\ngrest\base\Render;
use yii\base\InvalidConfigException;
use yii\base\ViewContextInterface;


/**
 * 
 * @property \luya\admin\ngrest\render\RenderCrudView $view
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class RenderCrud extends Render implements RenderInterface, ViewContextInterface, RenderCrudInterface
{
    const TYPE_LIST = 'list';

    const TYPE_CREATE = 'create';

    const TYPE_UPDATE = 'update';

    public $viewFile = 'crud.php';

    private $_permissions = [];

    private $_buttons;

    private $_view;

    private $_fields = [];

    private $_langs;

    public function can($type)
    {
        if (!array_key_exists($type, $this->_permissions)) {
            $this->_permissions[$type] = Yii::$app->auth->matchApi(Yii::$app->adminuser->getId(), $this->config->apiEndpoint, $type);
        }

        return $this->_permissions[$type];
    }

    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new RenderCrudView();
        }

        return $this->_view;
    }
    
    public function getViewPath()
    {
    	return '@admin/views/ngrest';
    }
    
    public function render()
    {
    	return $this->view->render($this->viewFile, [
            'canCreate' => $this->can(Auth::CAN_CREATE),
            'canUpdate' => $this->can(Auth::CAN_UPDATE),
            'canDelete' => $this->can(Auth::CAN_DELETE),
            'config' => $this->config,
    		'isInline' => $this->getIsInline(),
    		//'relationCall' => $this->getRelationCall(), // this is currently only used for the curd_relation view file, there for split the RenderCrud into two sepeare renderes.
        ], $this);
    }

    public function getApiEndpoint($append = null)
    {
        if ($append) {
            $append = '/' . ltrim($append, '/');
        }
        return 'admin/'.$this->getConfig()->getApiEndpoint() . $append;
    }
    
    public function getPrimaryKey()
    {
        return $this->config->primaryKey;
    }
    
    private $_relationCall = false;
    
    public function getRelationCall()
    {
    	return $this->_relationCall;
    }
    
    public function setRelationCall(array $options)
    {
    	$this->_relationCall = $options;
    }
    
    private $_isInline = false;

    /**
     * @var boolean Determine whether this ngrest config is runing as inline window mode (a modal dialog with the
     * crud inside) or not. When inline mode is enabled some features like ESC-Keys and URL chaning must be disabled.
     * @return bool
     */
    public function getIsInline()
    {
    	return $this->_isInline;	
    }
    
    public function setIsInline($inline)
    {
    	$this->_isInline = $inline;
    }

    public function getOrderBy()
    {
        if ($this->getConfig()->getDefaultOrderField() === false) {
            return false;
        }
        
    	return $this->getConfig()->getDefaultOrderDirection() . $this->getConfig()->getDefaultOrderField();
    }
    
    /*
     * OLD
     */

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
            
            foreach ($this->getConfig()->getRelataions() as $rel) {
                $api = Yii::$app->adminmenu->getApiDetail($rel['apiEndpoint']);
                
                if (!$api) {
                    throw new InvalidConfigException("The configured api relation '{$rel['apiEndpoint']}' does not exists in the menu elements. Maybe you have no permissions to access this API.");
                }
                
                $buttons[] = [
                    'ngClick' => 'tabService.addTab(item.'.$this->config->primaryKey.', \''.$api['route'].'\', \''.$rel['arrayIndex'].'\', \''.$rel['label'].'\', \''.$rel['modelClass'].'\')',
                    'icon' => 'chrome_reader_mode',
                    'label' => $rel['label'],
                ];
            }
            
            if ($this->can(Auth::CAN_UPDATE)) {
                // get all activeWindows assign to the crud
                foreach ($this->getActiveWindows() as $hash => $config) {
                    $buttons[] = [
                        'ngClick' => 'getActiveWindow(\''.$hash.'\', item.'.$this->config->primaryKey.')',
                        'icon' => $config['icon'],
                        'label' => $config['alias'],
                    ];
                }
            }
            
            // check if deletable is enabled
            if ($this->config->isDeletable() && $this->can(Auth::CAN_DELETE)) {
                $buttons[] = [
                    'ngClick' => 'deleteItem(item.'.$this->config->primaryKey.')',
                    'icon' => 'delete',
                    'label' => '',
                ];
            }
            // do we have an edit button
            if (count($this->getFields('update')) > 0 && $this->can(Auth::CAN_UPDATE)) {
                $buttons[] = [
                    'ngClick' => 'toggleUpdate(item.'.$this->config->primaryKey.')',
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
     * @todo do not return the specofic type content, but return an array contain more infos also about is multi linguage and foreach in view file!
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
                        'html' => '<label class="i18n__label">'.$element['alias'].'</label><div class="i18n__fields">',
                    ];
                }
                $ngModel = $this->i18nNgModelString($configContext, $element['name'], $lang['short_code']);
                $id = 'id-'.md5($ngModel.$lang['short_code']);
                // anzahl cols durch anzahl sprachen
                $return[] = [
                    'html' => '<div class="crud__i18n-col crud__i18n-col--{{(12/AdminLangService.selection.length)}}" ng-show="AdminLangService.isInSelection(\''.$lang['short_code'].'\')">'.$this->renderElementPlugins($configContext, $element['type'], $id, $element['name'], $ngModel, $element['alias'], true).'<div class="crud__flag"><span class="flag flag--'.$lang['short_code'].'"><span class="flag__fallback flag__fallback--colorized">'.$lang['short_code'].'</span></span></div></div>',
                ];

                ++$i;
            }
            $return[] = ['html' => '</div>'];

            return $return;
        }

        $ngModel = $this->ngModelString($configContext, $element['name']);
        $id = 'id-'.md5($ngModel);

        return [
            [
                'html' => $this->renderElementPlugins($configContext, $element['type'], $id, $element['name'], $ngModel, $element['alias'], false),
            ],
        ];
    }

    private function renderElementPlugins($configContext, $typeConfig, $elmnId, $elmnName, $elmnModel, $elmnAlias, $elmni18n)
    {
        $obj = NgRest::createPluginObject($typeConfig['class'], $elmnName, $elmnAlias, $elmni18n, $typeConfig['args']);
        $method = 'render'.ucfirst($configContext);
        $html = $obj->$method($elmnId, $elmnModel);

        return (is_array($html)) ? implode(" ", $html) : $html;
    }

    private function ngModelString($configContext, $fieldId)
    {
        return ($configContext == self::TYPE_LIST) ? 'item.'.$fieldId : 'data.'.$configContext.'.'.$fieldId;
    }

    private function i18nNgModelString($configContext, $fieldId, $lang)
    {
        return 'data.'.$configContext.'.'.$fieldId.'[\''.$lang.'\']';
    }
}
