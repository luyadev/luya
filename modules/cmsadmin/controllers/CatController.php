<?php
namespace cmsadmin\controllers;

class CatController extends \admin\base\Controller
{
    public function actionIndex()
    {
        $config = new \admin\ngrest\Config('api-cms-cat', 'id', ['title' => 'Kategorien', 'fa-icon' => 'fa-tasks']);

        $config->list->field("name", "Name")->text()->required();
        $config->list->field("default_nav_id", "Default-Nav-Id")->text()->required();
        $config->list->field("rewrite", "Rewrite")->text()->required();
        $config->list->field("id", "ID")->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $ngrest = new \admin\ngrest\NgRest($config);

        return $ngrest->render(new \admin\ngrest\render\RenderCrud());
    }
}
