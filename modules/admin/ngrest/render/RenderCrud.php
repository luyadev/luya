<?php

namespace admin\ngrest\render;

use Yii;
use DOMDocument;
use yii\base\View;
use admin\components\Auth;
use admin\models\Lang;

/**
 * @todo complet rewrite of this class - what is the best practive to acces data in the view? define all functiosn sindie here? re-create methods from config object?
 *  $this->config() $this....
 *
 * @author nadar
 */
class RenderCrud extends \admin\ngrest\base\Render implements \admin\ngrest\interfaces\Render
{
    const TYPE_LIST = 'list';

    const TYPE_CREATE = 'create';

    const TYPE_UPDATE = 'update';

    public $viewFile = '@admin/views/ngrest/render/crud.php';

    private $_permissions = [];

    private $_buttons = null;

    private $_view = null;

    private $_fields = [];

    private $_langs = null;

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
            $this->_view = new View();
        }

        return $this->_view;
    }

    public function render()
    {
        return $this->getView()->render($this->viewFile, array(
            'canCreate' => $this->can(Auth::CAN_CREATE),
            'canUpdate' => $this->can(Auth::CAN_UPDATE),
            'canDelete' => $this->can(Auth::CAN_DELETE),
            //'crud' => $this,
            'config' => $this->config,
            'activeWindowCallbackUrl' => 'admin/ngrest/callback',
        ), $this);
    }

    public function getRestUrl()
    {
        return 'admin/'.$this->config->apiEndpoint;
    }

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
     *
     * @return returns array with all buttons for this crud
     */
    public function getButtons()
    {
        if ($this->_buttons === null) {
            $buttons = [];
            // do we have an edit button
            if (count($this->getFields('update')) > 0 && $this->can(Auth::CAN_UPDATE)) {
                $buttons[] = [
                    'ngClick' => 'toggleUpdate(item.'.$this->config->primaryKey.', $event)',
                    'icon' => 'mdi-editor-mode-edit',
                    'label' => '',
                ];
            }
            // get all activeWindows assign to the crud
            foreach ($this->getActiveWindows() as $activeWindow) {
                $buttons[] = [
                    'ngClick' => 'getActiveWindow(\''.$activeWindow['activeWindowHash'].'\', item.'.$this->config->primaryKey.', $event)',
                    'icon' => '',
                    'label' => $activeWindow['alias'],
                ];
            }

            if ($this->config->isDeletable() && $this->can(Auth::CAN_DELETE)) {
                $buttons[] = [
                    'ngClick' => 'deleteItem(item.'.$this->config->primaryKey.', $event)',
                    'icon' => '',
                    'label' => 'Löschen',
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
        if (count($this->config->extraFields) > 0) {
            $query['expand'] = implode(',', $this->config->extraFields);
        }
        // return url decoed string from http_build_query
        return urldecode(http_build_query($query));
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

    private $_defaultLangShortCode = null;

    public function getDefaultLangShortCode()
    {
        if ($this->_defaultLangShortCode === null) {
            $lang = Lang::getDefault();
            $this->_defaultLangShortCode = $lang['short_code'];
        }

        return $this->_defaultLangShortCode;
    }

    /**
     * @todo do not return the specofic type content, but return an array contain more infos also about is multi linguage and foreach in view file! 
     *
     * @param unknown_type $element
     * @param string       $configContext list,create,update
     */
    public function createElements($element, $configContext)
    {
        if ($element['i18n'] && $configContext !== self::TYPE_LIST) {
            $i = 0;
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
                    'html' => '<div class="col s'.(12 / count($this->getLangs())).'">'.$this->renderElementPlugins($configContext, $element['plugins'], $id, $element['name'], $ngModel, $element['alias'], true).'</div>',
                ];

                ++$i;
            }
            $return[] = ['html' => '</div>'];

            return $return;
        }

        if ($element['i18n'] && $configContext == self::TYPE_LIST) {
            $element['name'] = $element['name'].'.'.$this->getDefaultLangShortCode();
        }

        $ngModel = $this->ngModelString($configContext, $element['name']);
        $id = 'id-'.md5($ngModel);

        return [
            [
                'html' => $this->renderElementPlugins($configContext, $element['plugins'], $id, $element['name'], $ngModel, $element['alias'], false),
            ],
        ];
    }

    private function renderElementPlugins($configContext, $plugins, $elmnId, $elmnName, $elmnModel, $elmnAlias, $elmnGridCols)
    {
        $doc = new DOMDocument('1.0');

        foreach ($plugins as $key => $plugin) {
            $doc = $this->renderPlugin($doc, $configContext, $plugin['class'], $plugin['args'], $elmnId, $elmnName, $elmnModel, $elmnAlias, $elmnGridCols);
        }

        return trim($doc->saveHTML());
    }

    private function renderPlugin($DOMDocument, $configContext, $className, $classArgs, $elmnId, $elmnName, $elmnModel, $elmnAlias, $elmnGridCols)
    {
        $ref = new \ReflectionClass($className);
        $obj = $ref->newInstanceArgs($classArgs);
        $obj->setConfig($elmnId, $elmnName, $elmnModel, $elmnAlias, $elmnGridCols);
        $method = 'render'.ucfirst($configContext);

        return $obj->$method($DOMDocument);
    }

    private function ngModelString($configContext, $fieldId)
    {
        return 'data.'.$configContext.'.'.$fieldId;
    }

    private function i18nNgModelString($configContext, $fieldId, $lang)
    {
        return 'data.'.$configContext.'.'.$fieldId.'[\''.$lang.'\']';
    }
}
