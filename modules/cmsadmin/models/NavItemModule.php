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

    /**
     * @todo: see if $pathAfterRoute could be available in the urlRules, otherwise display default
     * (non-PHPdoc)
     * @see cmsadmin\base.NavItemType::getContent()
     */
    public function getContent()
    {
        $module = $this->module_name;
        $pathAfterRoute = $this->getOption('restString');

        $moduleObject = \yii::$app->getModule($module);
        $moduleObject->setContext('cms');

        \yii::$app->request->setPathInfo($module.'/'.$pathAfterRoute);

        $mgr = new \luya\components\UrlManager();
        $mgr->addRules($moduleObject::$urlRules, true);
        $rq = $mgr->parseRequest(\yii::$app->request);

        return \yii::$app->runAction($rq[0], $rq[1]);
    }

    public function getHeaders()
    {
        return;
    }

    private function renderer()
    {
        /* --------------------- */

        // params from cms:

        $module = $this->module_name;
        $pathAfterRoute = $this->getOption('restString');

        $moduleObject = \yii::$app->getModule($module);
        $moduleObject->setContext('cms');
        \yii::$app->request->setPathInfo($module.$pathAfterRoute);

        $mgr = new \luya\components\UrlManager();
        $mgr->addRules($moduleObject::$urlRules, true);
        $rq = $mgr->parseRequest(\yii::$app->request);

        $x = \yii::$app->runAction($rq[0], $rq[1]);

        echo $x;

        /* ---------------------- */
    }
}
