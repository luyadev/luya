<?php
namespace admin\controllers;

class LangController extends \admin\base\Controller
{
    public function actionIndex()
    {
        $config = new \admin\ngrest\Config('api-admin-lang', 'id');

        $config->list->field("name", "Name")->text()->required();
        $config->list->field("short_code", "Kurz-Code")->text()->required();
        $config->list->field("id", "ID")->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $ngrest = new \admin\ngrest\NgRest($config);

        return $ngrest->render(new \admin\ngrest\render\RenderCrud());
    }
}
