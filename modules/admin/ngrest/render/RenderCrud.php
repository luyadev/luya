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

    public function render()
    {
        $view = new \yii\base\View();

        return $view->render("@admin/views/ngrest/render/crud.php", array(
            "crud" => $this,
            "config" => $this->config,
            "strapCallbackUrl" => "admin/ngrest/callback",
        ));
    }

    public function __get($key)
    {
        return $this->config->getKey($key);
    }

    /**
     *
     * @param unknown_type $element
     * @param string       $configContext list,create,update
     */
    public function createElement($element, $configContext)
    {
        $element['ngModel'] = $this->createNgModel($configContext, $element['name']);
        $element['id'] = "id-".md5($element['ngModel']);
        $doc = new \DOMDocument('1.0');
        foreach ($element['plugins'] as $key => $plugin) {
            $ref = new \ReflectionClass($plugin['class']);
            $obj = $ref->newInstanceArgs($plugin['args']);
            $obj->setConfig($element);
            $method = "render".ucfirst($configContext);
            $doc = $obj->$method($doc);
        }

        $html = $doc->saveHTML();

        return $html;
    }

    public function getFields($type)
    {
        $fields = [];
        foreach ($this->config->getKey($type) as $item) {
            $fields[] = $item['name'];
        }

        return $fields;
    }

    private function createNgModel($configContext, $fieldId)
    {
        return 'data.'.$configContext.'.'.$fieldId;
    }

    public function getStraps()
    {
        return ($straps = $this->config->getKey('strap')) ? $straps : [];
    }
}
