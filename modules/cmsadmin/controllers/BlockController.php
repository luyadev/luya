<?php
namespace cmsadmin\controllers;

class BlockController extends \admin\base\Controller
{
    public function actionIndex()
    {
        $config = new \admin\ngrest\Config('api-cms-block', 'id', ['title' => 'Blöcke', 'fa-icon' => 'fa-tasks']);

        $config->list->field("name", "Name")->text()->required();
       
        $config->create->field("name", "Name")->text()->required();
        $config->create->field("json_config", "JSON Config")->ace(['mode' => 'json']);
        $config->create->field("twig_frontend", "Twig Frontend")->ace(['mode' => 'twig']);
        $config->create->field("twig_admin", "Twig Admin")->ace(['mode' => 'twig']);

        $config->update->copyFrom('create');

        $ngrest = new \admin\ngrest\NgRest($config);

        return $ngrest->render((new \admin\ngrest\render\RenderCrud()));
    }
}
