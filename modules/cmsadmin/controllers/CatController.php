<?php
namespace cmsadmin\controllers;

class CatController extends \admin\base\Controller
{
    public function actionIndex()
    {
        $config = new \luya\ngrest\Config('api-cms-cat', 'id');

        $config->list->field("name", "Name")->text()->required();
        $config->list->field("default_nav_id", "Default-Nav-Id")->text()->required();
        $config->list->field("rewrite", "Rewrite")->text()->required();
        $config->list->field("id", "ID")->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $ngrest = new \luya\ngrest\NgRest($config);

        return $ngrest->render(new \luya\ngrest\render\RenderCrud());
    }
}
