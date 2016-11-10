<?php

namespace luya\console\commands;

use Yii;
use yii\console\Exception;
use luya\admin\models\Config;
use luya\admin\models\User;
use luya\admin\models\Group;

/**
 * Setup the Administration Interface.
 *
 * You can also use the parameters to run the setup command for example.
 *
 * ```
 * setup --email=foo@bar.com --password=test --firstname=John --lastname=Doe --interactive=0
 * ```
 *
 * This will perform the Setup task silent and does not prompt any questions.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class SetupController extends \luya\console\Command
{
    /**
     * @var string The email of the user to create.
     */
    public $email = null;
    
    /**
     * @var string The blank password of the user to create.
     */
    public $password = null;
    
    /**
     * @var string The firstname of the user to create.
     */
    public $firstname = null;
    
    /**
     * @var string The lastname of the user to create.
     */
    public $lastname = null;
    
    /**
     * @var string Whether the setup is interactive or not.
     */
    public $interactive = true;
    
    /**
     * @var string The name of the default language e.g. English
     */
    public $langName = null;
    
    /**
     * @var string The short code of the language e.g. en
     */
    public $langShortCode = null;
    
    /**
	 * @inheritdoc
	 */
    public function options($actionID)
    {
        return ['email', 'password', 'firstname', 'lastname', 'interactive'];
    }

    /**
     * Setup the administration area.
     *
     * This action of setup will add a new user, group, languaga, permissions and default homepage and container.
     *
     * @return boolean
     */
    public function actionIndex()
    {
        if (!Config::has('last_import_timestamp')) {
            return $this->outputError("You have to run the 'import' process first. run in terminal: ./vendor/bin/luya import");
        }
    
        if (Config::has('setup_command_timestamp')) {
            return $this->outputError('The setup process already have been started on the '.date('d.m.Y H:i', Config::get('setup_command_timestamp')).'. If you want to reinstall your luya project. Drop all tables from your Database, run the migrate command, run the import command and then re-run the setup command');
        }
    
        if (empty($this->email)) {
            $this->email = $this->prompt('User E-Mail:', ['required' => true]);
        }
    
        if (empty($this->password)) {
            $this->password = $this->prompt('User Password:', ['required' => true]);
        }
    
        if (empty($this->firstname)) {
            $this->firstname = $this->prompt('Firstname:', ['required' => true]);
        }
    
        if (empty($this->lastname)) {
            $this->lastname = $this->prompt('Lastname:', ['required' => true]);
        }
    
        if (empty($this->langName)) {
            $this->langName = $this->prompt('Standard language:', ['required' => true, 'default' => 'English']);
        }
        
        if (empty($this->langShortCode)) {
            $this->langShortCode = $this->prompt('Short-Code of the Standard language:', ['required' => true, 'default' => 'en', 'validator' => function ($input, &$error) {
                if (strlen($input) !== 2) {
                    $error = 'The Short-Code must be 2 chars length only. Examples: de, en, fr, ru';
                    return false;
                }
                return true;
            }]);
        }
        
        if ($this->interactive) {
            if ($this->confirm("Confirm your login details in order to proceed with the Setup. E-Mail: {$this->email} Password: {$this->password} - Are those informations correct?") !== true) {
                return $this->outputError('Abort by user.');
            }
        }
    
        $salt = Yii::$app->security->generateRandomString();
        $pw = Yii::$app->security->generatePasswordHash($this->password.$salt);
    
        $this->insert('admin_user', [
            'title' => 1,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $pw,
            'password_salt' => $salt,
            'is_deleted' => 0,
        ]);
    
        $this->insert('admin_group', [
            'name' => 'Administrator',
            'text' => 'Administrator Accounts have full access to all Areas and can create, update and delete all data records.',
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
            'name' => $this->langName,
            'short_code' => $this->langShortCode,
            'is_default' => 1,
        ]);
    
        if (Yii::$app->hasModule('cms')) {
            // insert default page
            $this->insert("cms_nav", ['nav_container_id' => 1, 'parent_nav_id' => 0, 'sort_index' => 0, 'is_deleted' => 0, 'is_hidden' => 0, 'is_offline' => 0, 'is_home' => 1, 'is_draft' => 0]);
            $this->insert("cms_nav_item", ['nav_id' => 1, 'lang_id' => 1, 'nav_item_type' => 1, 'nav_item_type_id' => 1, 'create_user_id' => 1, 'update_user_id' => 1, 'timestamp_create' => time(), 'title' => 'Homepage', 'alias' => 'homepage']);
            $this->insert('cms_nav_item_page', ['layout_id' => 1, 'create_user_id' => 1, 'timestamp_create' => time(), 'version_alias' => 'Initial', 'nav_item_id' => 1]);
        }
    
        Config::set('setup_command_timestamp', time());
    
        return $this->outputSuccess("Setup is finished. You can now login into the Administration-Area with the E-Mail '{$this->email}'.");
    }
    
    /**
     * Create a new user and append them to an existing group.
     *
     * @return boolean
     */
    public function actionUser()
    {
        while (true) {
            $email = $this->prompt('User E-Mail:');
            if (!empty(User::findByEmail($email))) {
                $this->outputError('The provided E-Mail already exsists in the System.');
            } else {
                break;
            }
        }

        $titleArray = ['Mr' => 1, 'Mrs' => 2];
        $title = $this->select('Title:', $titleArray);

        $firstname = $this->prompt('Firstname:');
        $lastname = $this->prompt('Lastname:');
        $password = $this->prompt('User Password:');

        if ($this->confirm("Are you sure to create the User '$email'?") !== true) {
            return $this->outputError('Abort user creation process.');
        }

        $user = new User();
        $user->email = $email;
        $user->password_salt = Yii::$app->getSecurity()->generateRandomString();
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($password.$user->password_salt);
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->title = $titleArray[$title];
        if (!$user->save()) {
            throw new Exception("Unable to create new user.");
        }

        $groupSelect = [];

        foreach (Group::find()->all() as $entry) {
            $groupSelect[$entry->id] = $entry->name.' ('.$entry->text.')';
            $this->output($entry->id.' - '.$groupSelect[$entry->id]);
        }
        $groupId = $this->select('Select Group the user should belong to:', $groupSelect);

        $this->insert('admin_user_group', [
            'user_id' => $user->id,
            'group_id' => $groupId,
        ]);

        return $this->outputSuccess("The user ($email) has been created.");
    }
    
    /**
     * Helper to insert data in database table.
     *
     * @param string $table The database table
     * @param array $fields The array with insert fields
     */
    private function insert($table, array $fields)
    {
        return Yii::$app->db->createCommand()->insert($table, $fields)->execute();
    }
}
