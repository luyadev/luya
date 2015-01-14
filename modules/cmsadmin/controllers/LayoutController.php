<?php
namespace cmsadmin\controllers;

class LayoutController extends \admin\base\Controller
{
    public function actionIndex()
    {
        $config = new \luya\ngrest\Config('api-cms-layout', 'id');

        $config->list->field("name", "Name")->text()->required();
        $config->list->field("json_config", "JSON Config")->ace();
        $config->list->field("view_file", "Path to View-File")->text()->required();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $ngrest = new \luya\ngrest\NgRest($config);

        return $ngrest->render((new \luya\ngrest\render\RenderCrud()));
    }
}
