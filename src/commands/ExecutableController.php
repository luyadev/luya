<?php

namespace luya\commands;

use Yii;
use yii\helpers\Console;

/**
 * Find all files inside all modules to the specific action type (example auth() = auth.php files), include them
 * and do something with the response array inside of the files.
 *
 * @todo rename later on to configurables? or sth. else.
 *
 * @author nadar
 */
class ExecutableController extends \yii\console\Controller
{
    private $_dirs = [];

    private $_scanFolders = ['blocks', 'filters'];

    public function init()
    {
        foreach (Yii::$app->modules as $key => $item) {
            $module = Yii::$app->getModule($key);
            foreach ($this->_scanFolders as $folderName) {
                $folder = $module->getBasePath().DIRECTORY_SEPARATOR.$folderName;
                if (file_exists($folder)) {
                    $this->_dirs[$folderName][] = [
                        'ns' => '\\'.$module->getNamespace().'\\'.$folderName,
                        'module' => $module->id,
                        'folderPath' => $folder.DIRECTORY_SEPARATOR,
                        'folderName' => $folderName,
                        'files' => scandir($folder),
                    ];
                }
            }
        }
        // add scan to app folders
        foreach ($this->_scanFolders as $folderName) {
            $path = Yii::getAlias("@app/$folderName");
            if (file_exists($path)) {
                $this->_dirs[$folderName][] = [
                    'ns' => '\\app\\'.$folderName,
                    'module' => '@app',
                    'folderPath' => $path.DIRECTORY_SEPARATOR,
                    'files' => scandir($path),
                ];
            }
        }
    }

    public function getFilesNamespace($folderName)
    {
        if (!array_key_exists($folderName, $this->_dirs)) {
            return [];
        }

        $files = [];

        foreach ($this->_dirs[$folderName] as $item) {
            foreach ($item['files'] as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $files[] = $item['ns'].'\\'.pathinfo($file, PATHINFO_FILENAME);
            }
        }

        return $files;
    }

    public function actionIndex()
    {
        $this->stdout("the following exec commands are avialable:\n- exec/auth\n\n- exec/import\n");
    }

    public function actionImport()
    {
        $this->execAuth();
        /*
        $import = $this->execImport();
        if (count($import) == 0) {
            echo 'No response from the exec/import.';
            exit(1);
        }
        print_r($import);
        exit(0);
        */
    }

    /*
    private function execImport()
    {
        $response = [];
        $modules = \yii::$app->getModules();
        foreach ($modules as $id => $item) {
            $object = \yii::$app->getModule($id);
            if (method_exists($object, 'import')) {
                $importResponse = $object->import($this);
                if ($importResponse !== false) {
                    $response[$id] = $importResponse;
                }
            }
        }

        return $response;
    }
    
    */

    /**
     * find all auth.php files, invoke them and return to \yii::$app->auth->addRule.
     *
     * before:
     * ```
     * foreach ($this->getFiles('auth.php') as $source) {
     *     include($source);
     * }
     * ```
     */
    private function execAuth()
    {
        $modules = Yii::$app->getModules();
        $data = [
            'apis' => [],
            'routes' => [],
        ];
        foreach ($modules as $id => $item) {
            $object = Yii::$app->getModule($id);
            if (method_exists($object, 'getAuthApis')) {
                foreach ($object->getAuthApis() as $item) {
                    $data['apis'][] = $item['api'];
                    Yii::$app->auth->addApi($object->id, $item['api'], $item['alias']);
                }
            }

            if (method_exists($object, 'getAuthRoutes')) {
                foreach ($object->getAuthRoutes() as $item) {
                    $data['routes'][] = $item['route'];
                    Yii::$app->auth->addRoute($object->id, $item['route'], $item['alias']);
                }
            }
        }

        $toClean = Yii::$app->auth->prepareCleanup($data);
        if (count($toClean) > 0) {
            foreach ($toClean as $rule) {
                echo $this->ansiFormat('old auth rule: "'.$rule['alias_name'].'" in module '.$rule['module_name'], Console::FG_RED).PHP_EOL;
            }
            if ($this->confirm('Delete old permission rules?')) {
                Yii::$app->auth->executeCleanup($toClean);
            }
        }
    }

    private function insert($table, $fields)
    {
        return \yii::$app->db->createCommand()->insert($table, $fields)->execute();
    }

    /**
     * @todo use options instead, override options()
     * @todo see if admin is availoable
     *
     * @param string $email
     * @param string $password
     */
    public function actionSetup()
    {
        $email = $this->prompt('Benutzer E-Mail:');
        $password = $this->prompt('Benutzer Passwort:');
        $firstname = $this->prompt('Vorname:');
        $lastname = $this->prompt('Nachname:');
        if (!$this->confirm("Create a new user ($email) with password '$password'?")) {
            exit(1);
        }

        $this->execAuth();

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
        $data = \yii::$app->db->createCommand("SELECT * FROM admin_auth WHERE api='api-admin-user' OR api='api-admin-group'")->queryAll();

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

        $this->insert('admin_storage_effect', [
            'name' => 'Thumbnail',
            'identifier' => 'thumbnail',
            'imagine_name' => 'thumbnail',
            'imagine_json_params' => json_encode(['vars' => [
                ['var' => 'type', 'label' => 'outbound or inset'], // THUMBNAIL_OUTBOUND & THUMBNAIL_INSET
                ['var' => 'width', 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);

        $this->insert('admin_storage_effect', [
            'name' => 'Zuschneiden',
            'identifier' => 'resize',
            'imagine_name' => 'resize',
            'imagine_json_params' => json_encode(['vars' => [
                ['var' => 'width', 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);

        $this->insert('admin_storage_effect', [
            'name' => 'Crop',
            'identifier' => 'crop',
            'imagine_name' => 'crop',
            'imagine_json_params' => json_encode(['vars' => [
                ['var' => 'width', 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);

        $this->execImport();

        echo "You can now login with E-Mail: '$email' and password: '$password'";
        exit(0);
    }
}
