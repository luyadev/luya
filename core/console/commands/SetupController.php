<?php

namespace luya\console\commands;

use Yii;
use admin\models\Config;
use admin\models\User;
use admin\models\Group;

class SetupController extends \luya\console\Command
{
    private function insert($table, $fields)
    {
        return Yii::$app->db->createCommand()->insert($table, $fields)->execute();
    }

    /**
     * @todo don't write directly in db table (admin_user_group)
     * @todo reuse encode password function from user model
     * @todo find better solution for while(true)/break loop
     * @todo find better solution for title array/selection
     * @todo error handling (validate, can't save models)
     *
     * @param $title
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $password
     */
    public function actionUser()
    {
        while (true) {
            $email = $this->prompt('Benutzer E-Mail:');
            if (!empty(User::findByEmail($email))) {
                $this->outputError('Email existiert bereits!');
            } else {
                break;
            }
        }

        $titleArray = ['Herr' => 1, 'Frau' => 2];
        $title = $this->select('Anrede:', [
            'Herr' => '1', 'Frau' => '2',
        ]);

        $firstname = $this->prompt('Vorname:');
        $lastname = $this->prompt('Nachname:');
        $password = $this->prompt('Benutzer Passwort:');

        if (!$this->confirm("Einen neuen Benutzer '$title $firstname $lastname, Email $email' mit dem Passwort '$password' anlegen?")) {
            return $this->outputError('Abort user creation process.');
        }

        $user = new User();
        $user->email = $email;
        $user->password_salt = Yii::$app->getSecurity()->generateRandomString();
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($password.$user->password_salt);
        $user->firstname = $firstname;
        $user->lastname = $lastname;

        $user->title = $titleArray[$title];
        $user->save();
        $userId = $user->id;

        $groupEntries = Group::find()->all();
        $groupSelect = [];

        $this->output('');
        foreach ($groupEntries as $entry) {
            $groupSelect[$entry->id] = $entry->name.' ('.$entry->text.')';
            $this->output($entry->id.' - '.$groupSelect[$entry->id]);
        }
        $groupId = $this->select('Benutzergruppe:', $groupSelect);

        $this->insert('admin_user_group', [
            'user_id' => $userId,
            'group_id' => $groupId,
        ]);

        return $this->outputSuccess("Der Benutzer $firstname $lastname wurde erfolgreich angelegt.");
    }

    /**
     * @todo use options instead, override options()
     * @todo see if admin is availoable
     *
     * @param string $email
     * @param string $password
     */
    public function actionIndex()
    {
        if (!Config::has('last_import_timestamp')) {
            return $this->outputError("You have to run the 'import' process first. run in terminal: ./vendor/bin/luya import");
        }

        if (Config::has('setup_command_timestamp')) {
            return $this->outputError('The setup process already have been started on the '.date('d.m.Y H:i', Config::get('setup_command_timestamp')).'. If you want to reinstall your luya project. Drop all tables from your Database, run the migrate command, run the import command and then re-run the setup command');
        }

        $email = $this->prompt('Benutzer E-Mail:');
        $password = $this->prompt('Benutzer Passwort:');
        $firstname = $this->prompt('Vorname:');
        $lastname = $this->prompt('Nachname:');
        if (!$this->confirm("Create a new user ($email) with password '$password'?")) {
            return $this->outputError('Abort by user.');
        }

        $salt = Yii::$app->getSecurity()->generateRandomString();
        $pw = Yii::$app->getSecurity()->generatePasswordHash($password.$salt);

        $this->insert('admin_user', [
            'title' => 1,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $pw,
            'password_salt' => $salt,
            'is_deleted' => 0,
        ]);

        $this->insert('admin_group', [
            'name' => 'Adminstrator',
            'text' => 'Administrator Accounts',
        ]);

        $this->insert('admin_user_group', [
            'user_id' => 1,
            'group_id' => 1,
        ]);

        // get the api-admin-user and api-admin-group auth rights
        $data = Yii::$app->db->createCommand("SELECT * FROM admin_auth WHERE api='api-admin-user' OR api='api-admin-group'")->queryAll();

        foreach ($data as $item) {
            $this->insert('admin_group_auth', [
                'group_id' => 1,
                'auth_id' => $item['id'],
                'crud_create' => 1,
                'crud_update' => 1,
                'crud_delete' => 1,
            ]);
        }

        $this->insert('admin_lang', [
            'name' => 'English',
            'short_code' => 'en',
            'is_default' => 1,
        ]);
        
        if (Yii::$app->hasModule('cms')) {
            // insert default page
            $this->insert("cms_nav", ['nav_container_id' => 1, 'parent_nav_id' => 0, 'sort_index' => 0, 'is_deleted' => 0, 'is_hidden' => 0, 'is_offline' => 0, 'is_home' => 1, 'is_draft' => 0]);
            $this->insert("cms_nav_item", ['nav_id' => 1, 'lang_id' => 1, 'nav_item_type' => 1, 'nav_item_type_id' => 1, 'create_user_id' => 1, 'update_user_id' => 1, 'timestamp_create' => time(), 'title' => 'Homepage', 'alias' => 'homepage']);
            $this->insert('cms_nav_item_page', ['layout_id' => 1, 'create_user_id' => 1, 'timestamp_create' => time(), 'version_alias' => 'Initial', 'nav_item_id' => 1]);
        }

        Config::set('setup_command_timestamp', time());

        return $this->outputSuccess("You can now login with the Email '$email' and password '$password'.");
    }
}
