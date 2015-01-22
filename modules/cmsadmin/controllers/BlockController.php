<?php
namespace cmsadmin\controllers;

class BlockController extends \admin\base\Controller
{
    public function actionIndex()
    {
        $config = new \luya\ngrest\Config('api-cms-block', 'id', ['title' => 'Blöcke', 'fa-icon' => 'fa-tasks']);

        $config->list->field("name", "Name")->text()->required();
        $config->list->field("json_config", "JSON Config")->ace(['mode' => 'json']);
        $config->list->field("twig_frontend", "Twig Frontend")->ace(['mode' => 'twig']);
        $config->list->field("twig_admin", "Twig Admin")->ace(['mode' => 'twig']);

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $ngrest = new \luya\ngrest\NgRest($config);

        return $ngrest->render((new \luya\ngrest\render\RenderCrud()));
    }
}
