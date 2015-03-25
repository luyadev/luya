<?php

namespace luya\commands;

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

    public function init()
    {
        foreach (\yii::$app->modules as $key => $item) {
            $module = \Yii::$app->getModule($key);
            $folder = $module->getBasePath().DIRECTORY_SEPARATOR.'executables';
            if (file_exists($folder)) {
                $this->_dirs[] = [
                    'module' => $module->id,
                    'folderPath' => $folder.DIRECTORY_SEPARATOR,
                    'files' => scandir($folder),
                ];
            }
        }
    }

    public function getFiles($fileName)
    {
        $files = [];
        foreach ($this->_dirs as $item) {
            foreach ($item['files'] as $file) {
                if ($file == $fileName) {
                    $files[] = $item['folderPath'].$file;
                }
            }
        }

        return $files;
    }

    public function actionIndex()
    {
        $this->stdout("use: exec/auth\n");
    }

    /**
     * find all auth.php files, invoke them and return to \yii::$app->luya->auth->addRule.
     * 
     * before: 
     * ```
     * foreach ($this->getFiles('auth.php') as $source) {
     *     include($source);
     * }
     * ```
     */
    public function actionAuth()
    {
        $modules = \yii::$app->getModules();
        foreach ($modules as $id => $item) {
            $object = \yii::$app->getModule($id);
            if (method_exists($object, 'getAuthApis')) {
                foreach ($object->getAuthApis() as $item) {
                    \yii::$app->luya->auth->addApi($object->id, $item['api'], $item['alias']);
                }
            }
            
            if (method_exists($object, 'getAuthRoutes')) {
                foreach ($object->getAuthRoutes() as $item) {
                    \yii::$app->luya->auth->addRoute($object->id, $item['route'], $item['alias']);
                }
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
     * @param string $email
     * @param string $password
     */
    public function actionSetup($email, $password)
    {
        if (!$this->confirm("create setup with email $email and password $password?")) {
            exit(1);
        }
        
        $this->actionAuth();
        // create user
        
        $salt = \Yii::$app->getSecurity()->generateRandomString();
        $pw = \Yii::$app->getSecurity()->generatePasswordHash($password.$salt);
        
        $this->insert("admin_user", [
            "firstname" => "Zephir",
            "lastname" => "Software Design AG",
            "email" => $email,
            "password" => $pw,
            "password_salt" => $salt,
            "is_deleted" => 0,
        ]);
        
        $this->insert("admin_group", [
            "name" => "Adminstrator",
            "text" => "Administrator Accounts"     
        ]);
        
        $this->insert("admin_user_group", [
            "user_id" => 1,
            "group_id" => 1
        ]);
        
        // get the api-admin-user and api-admin-group auth rights
        $data = \yii::$app->db->createCommand("SELECT * FROM admin_auth WHERE api='api-admin-user' OR api='api-admin-group'")->queryAll();
        
        foreach ($data as $item) {
            $this->insert("admin_group_auth", [
                "group_id" => 1,
                "auth_id" => $item['id'],
                "crud_create" => 1,
                "crud_update" => 1,
                "crud_delete" => 1     
            ]);
        }
        
        $this->insert("admin_lang", [
            "name" => "Deutsch",
            "short_code" => "de",
            "is_default" => 1,
        ]);
        
        $this->insert("admin_storage_effect", [
            "name" => "Thumbnail",
            "imagine_name" => "thumbnail",
            "imagine_json_params" => json_encode(['vars' => [
                ['var' => "width", 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);
    
        $this->insert("admin_storage_effect", [
            "name" => "Zuschneiden",
            "imagine_name" => "resize",
            "imagine_json_params" => json_encode(['vars' => [
                ['var' => "width", 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);
    
        $this->insert("admin_storage_effect", [
            "name" => "Crop",
            "imagine_name" => "crop",
            "imagine_json_params" => json_encode(['vars' => [
                ['var' => "width", 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);
        
        echo "You can now login with E-Mail: '$email' and password: '$password'";
    }
}
