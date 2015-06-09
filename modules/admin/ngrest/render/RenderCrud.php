<?php

namespace admin\ngrest\render;

use admin\ngrest\RenderAbstract;
use admin\ngrest\RenderInterface;

/**
 * @todo complet rewrite of this class - what is the best practive to acces data in the view? define all functiosn sindie here? re-create methods from config object?
 *  $this->config() $this....
 *
 * @author nadar
 */
class RenderCrud extends RenderAbstract implements RenderInterface
{
    const TYPE_LIST = 'list';

    const TYPE_CREATE = 'create';

    const TYPE_UPDATE = 'update';

    public function __get($key)
    {
        return $this->config->getKey($key);
    }

    public function render()
    {
        $view = new \yii\base\View();

        return $view->render('@admin/views/ngrest/render/crud.php', array(
            'crud' => $this,
            'config' => $this->config,
            'activeWindowCallbackUrl' => 'admin/ngrest/callback',
        ));
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
        $buttons = [];
        // do we have an edit button
        if (count($this->getFields('update')) > 0) {
            $buttons[] = [
                'ngClick' => 'toggleUpdate(item.'.$this->config->getRestPrimaryKey().', $event)',
                'icon' => 'mdi-editor-mode-edit',
                'label' => '',
            ];
        }
        // get all activeWindows assign to the crud
        foreach ($this->getActiveWindows() as $activeWindow) {
            $buttons[] = [
                'ngClick' => 'getActiveWindow(\''.$activeWindow['activeWindowHash'].'\', item.'.$this->config->getRestPrimaryKey().', $event)',
                'icon' => '',
                'label' => $activeWindow['alias'],
            ];
        }

        return $buttons;
    }

    public function apiQueryString($type)
    {
        // ngrestCall was previous ngrestExpandI18n
        // ($scope.config.apiEndpoint + '?ngrestExpandI18n=true&fields=' + $scope.config.list.join()
        return 'ngrestCall=true&fields='.implode(',', $this->getFields($type)).'&expand='.implode(',', $this->config->extraFields);
    }

    public function getFields($type)
    {
        $fields = [];
        foreach ($this->config->getKey($type) as $item) {
            $fields[] = $item['name'];
        }

        return $fields;
    }

    public function getActiveWindows()
    {
        return ($activeWindows = $this->config->getKey('aw')) ? $activeWindows : [];
    }

    /**
     * @todo do not return the specofic type content, but return an array contain more infos also about is multi linguage and foreach in view file! 
     * @param unknown_type $element
     * @param string       $configContext list,create,update
     */
    public function createElements($element, $configContext)
    {
        if ($element['i18n'] && $configContext !== self::TYPE_LIST) {
            $return = [];
            foreach (\admin\models\Lang::find()->all() as $l => $v) {
                $ngModel = $this->i18nNgModelString($configContext, $element['name'], $v->short_code);
                $id = 'id-'.md5($ngModel.$v->short_code);
                // anzahl cols durch anzahl sprachen
                $return[] = [
                    'id' => $id,
                    'label' => $element['alias'] . ' ' . $v->name,
                    'html' => $this->renderElementPlugins($configContext, $element['plugins'], $id, $element['name'], $ngModel, $element['alias'] . ' ' . $v->name, $element['gridCols'])
                ];
            }

            return $return;
        }

        if ($element['i18n'] && $configContext == self::TYPE_LIST) {
            $element['name'] = $element['name'].'.de'; // @todo get default language!
        }

        $ngModel = $this->ngModelString($configContext, $element['name']);
        $id = 'id-'.md5($ngModel);

        return [
            [
                'id' => $id,
                'label' => $element['alias'],
                'html' => $this->renderElementPlugins($configContext, $element['plugins'], $id, $element['name'], $ngModel, $element['alias'], $element['gridCols']),
            ]
        ];
    }

    private function renderElementPlugins($configContext, $plugins, $elmnId, $elmnName, $elmnModel, $elmnAlias, $elmnGridCols)
    {
        $doc = new \DOMDocument('1.0');

        foreach ($plugins as $key => $plugin) {
            $doc = $this->renderPlugin($doc, $configContext, $plugin['class'], $plugin['args'], $elmnId, $elmnName, $elmnModel, $elmnAlias, $elmnGridCols);
        }

        return $doc->saveHTML();
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
