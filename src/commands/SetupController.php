<?php

namespace luya\commands;

use Yii;
use admin\models\Config;
use admin\models\User;
use admin\models\Group;

class SetupController extends \luya\base\Command
{
    private function insert($table, $fields)
    {
        return Yii::$app->db->createCommand()->insert($table, $fields)->execute();
    }

    /**
     * @todo don't write directly in db table (admin_user_group)
     * @todo reuse encode password function from user model
     * @todo finde better solution for while(true)/break loop
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

        while(true){
            $email = $this->prompt('Benutzer E-Mail:');

            if(!empty(User::findByEmail($email))) {
                $this->outputError('Email existiert bereits!');
            } else {
                break;
            }
        }

        $titleArray = ['Herr' => 1, 'Frau' => 2];
        $title = $this->select("Anrede:", [
                'Herr' => '1', 'Frau' => '2'
            ]);

        $firstname = $this->prompt('Vorname:');
        $lastname = $this->prompt('Nachname:');
        $password = $this->prompt('Benutzer Passwort:');

        if (!$this->confirm("Einen neuen Benutzer '$title $firstname $lastname, Email $email' mit dem Passwort '$password' anlegen?")) {
            return 1;
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

        $groupModel = new Group();
        $groupEntries = $groupModel->find()->all();
        $groupSelect = [];

        $this->output('');
        foreach($groupEntries as $entry) {
            $groupSelect[$entry->id] = $entry->name . ' (' . $entry->text. ')';
            $this->output($entry->id . ' - ' . $groupSelect[$entry->id]);
        }
        $groupId = $this->select("Benutzergruppe:", $groupSelect);

        $this->insert('admin_user_group', [
                'user_id' => $userId,
                'group_id' => $groupId,
        ]);

        $this->outputSuccess("Neuer Nutzer erfolgreich angelegt!");
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
            echo PHP_EOL . 'Info: You have to run the "import" process first. run in terminal: ./vendor/bin/luya import' . PHP_EOL . PHP_EOL;
            return 1;
        }
        
        if (Config::has('setup_command_timestamp')) {
            echo PHP_EOL . 'Error: The setup process already have been started on the '.date('d.m.Y H:i', Config::get('setup_command_timestamp')) . '. If you want to reinstall your luya project. Drop all tables from your Database, run the migrate command, run the import command and then re-run the setup command.' . PHP_EOL . PHP_EOL;
            return 1;
        }

        $email = $this->prompt('Benutzer E-Mail:');
        $password = $this->prompt('Benutzer Passwort:');
        $firstname = $this->prompt('Vorname:');
        $lastname = $this->prompt('Nachname:');
        if (!$this->confirm("Create a new user ($email) with password '$password'?")) {
            return 1;
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
            'name' => 'Deutsch',
            'short_code' => 'de',
            'is_default' => 1,
        ]);

        Config::set('setup_command_timestamp', time());

        echo "You can now login with E-Mail: '$email' and password: '$password'";

        return 0;
    }
}
