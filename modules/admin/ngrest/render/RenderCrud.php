<?php
namespace admin\ngrest\render;

use admin\ngrest\RenderAbstract;
use admin\ngrest\RenderInterface;

/**
 * @todo complet rewrite of this class - what is the best practive to acces data in the view? define all functiosn sindie here? re-create methods from config object?
 *  $this->config() $this....
 * @author nadar
 *
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

        return $view->render("@admin/views/ngrest/render/crud.php", array(
            "crud" => $this,
            "config" => $this->config,
            "strapCallbackUrl" => "admin/ngrest/callback",
        ));
    }

    public function getFields($type)
    {
        $fields = [];
        foreach ($this->config->getKey($type) as $item) {
            $fields[] = $item['name'];
        }
    
        return $fields;
    }
    
    public function getStraps()
    {
        return ($straps = $this->config->getKey('strap')) ? $straps : [];
    }
    
    /**
     *
     * @param unknown_type $element
     * @param string       $configContext list,create,update
     */
    public function createElement($element, $configContext)
    {
        if ($element['i18n'] && $configContext !== self::TYPE_LIST) {
            $return = [];
            foreach(\admin\models\Lang::find()->all() as $l => $v) {
                $ngModel = $this->i18nNgModelString($configContext, $element['name'], $v->short_code);
                $id = "id-".md5($ngModel);
                
                $return[] = $v->short_code . ':<br />' . $this->renderElementPlugins($configContext, $element['plugins'], $id, $element['name'], $ngModel, $element['alias']);
            }
            return implode("", $return);
        } else {
            
            $ngModel = $this->ngModelString($configContext, $element['name']);
            $id = "id-".md5($ngModel);
            
            return $this->renderElementPlugins($configContext, $element['plugins'], $id, $element['name'], $ngModel, $element['alias']);        
        }
    }
    
    private function renderElementPlugins($configContext, $plugins, $elmnId, $elmnName, $elmnModel, $elmnAlias)
    {
        $doc = new \DOMDocument('1.0');
        
        foreach ($plugins as $key => $plugin) {
            $doc = $this->renderPlugin($doc, $configContext, $plugin['class'], $plugin['args'], $elmnId, $elmnName, $elmnModel, $elmnAlias);
        }
        
        return $doc->saveHTML();
    }
    
    private function renderPlugin($DOMDocument, $configContext, $className, $classArgs, $elmnId, $elmnName, $elmnModel, $elmnAlias)
    {
        $ref = new \ReflectionClass($className);
        $obj = $ref->newInstanceArgs($classArgs);
        $obj->setConfig($elmnId, $elmnName, $elmnModel, $elmnAlias);
        $method = "render".ucfirst($configContext);
        return $obj->$method($DOMDocument);
    }
    
    private function ngModelString($configContext, $fieldId)
    {
        return 'data.'.$configContext.'.'.$fieldId;
    }
    
    private function i18nNgModelString($configContext, $fieldId, $lang)
    {
        return 'data.'.$configContext.'.'.$fieldId.'[\'' . $lang . '\']';
    }
}
