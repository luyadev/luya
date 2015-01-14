<?php
namespace admin\controllers;

class UserController extends \admin\base\Controller
{
    public function actionIndex()
    {
        $config = new \luya\ngrest\Config('api-admin-user', 'id');

        $config->strap->register(new \admin\straps\ChangePassword(), "Passwort ändern");

        $config->strap->register(new \admin\straps\Delete(), "Löschen");

        $config->create->field("title", "Anrede")->select()->optionValue(\admin\models\User::getTitles());
        $config->create->field("firstname", "Vorname")->text()->required();
        $config->create->field("lastname", "Nachname")->text()->required();
        $config->create->field("email", "E-Mail-Adresse")->text()->required();
        $config->create->field("password", "Passwort")->password()->required();

        $config->list->field("id", "ID")->text();
        $config->list->field("firstname", "Vorname")->text();
        $config->list->field("lastname", "Nachname")->text();
        $config->update->copyFrom('create', ['password']);

        $ngrest = new \luya\ngrest\NgRest($config);

        return $ngrest->render(new \luya\ngrest\render\RenderCrud());
    }
}
