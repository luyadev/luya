<?php
namespace cmsadmin\models;

class NavItemModule extends \cmsadmin\base\NavItemType
{
    private $_suffix = null;

    public static function tableName()
    {
        return 'cms_nav_item_module';
    }

    public function rules()
    {
        return [
            [['module_name'], 'required']
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['module_name'],
            'restupdate' => ['module_name']
        ];
    }

    private $_module = null;

    private $_context = null;

    private function getModule()
    {
        if ($this->_module !== null) {
            return $this->_module;
        }

        $module = $this->module_name;

        $this->_module = \yii::$app->getModule($module);
        $this->_module->setContext('cms');
        $this->_module->setContextOptions($this->getOptions());

        return $this->_module;
    }

    /**
     * @todo: see if $pathAfterRoute could be available in the urlRules, otherwise display default
     * (non-PHPdoc)
     * @see cmsadmin\base.NavItemType::getContent()
     */
    public function getContent()
    {
        $module = $this->getModule();

        $pathAfterRoute = $this->getOption('restString');

        \yii::$app->request->setPathInfo($this->module_name.'/'.$pathAfterRoute);

        $mgr = new \luya\components\UrlManager();
        $mgr->addRules($module::$urlRules, true);
        $rq = $mgr->parseRequest(\yii::$app->request);
        $args = $rq[1];
        $r = $module->findControllerRoute($rq[0]);
        $controller = $module->createController($r);

        $action = $controller[0]->runAction($controller[1], $args);

        $this->_context = [];

        foreach ($controller[0]->propertyMap as $prop) {
            $this->_context[$prop] = $controller[0]->$prop;
        }

        return $action;
    }

    public function getHeaders()
    {
        return;
    }

    public function getContext()
    {
        return $this->_context;
    }
}
