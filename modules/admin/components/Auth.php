<?php

namespace admin\components;

use Yii;
use Exception;
use \yii\db\Query;
use \yii\helpers\ArrayHelper;
use \admin\models\UserOnline;

class Auth extends \yii\base\Component
{
    const CAN_CREATE = 1;
    
    const CAN_UPDATE = 2;
    
    const CAN_DELETE = 3;
    
    private function permissionWeight($create, $update, $delete)
    {
        $create = $create ? 1 : 0;
        $update = $update ? 3 : 0;
        $delete = $delete ? 5 : 0;
        
        return ($create + $update + $delete);
    }
    
    private function permissionVerify($type, $permissionWeight)
    {
        switch($type) {
            case self::CAN_CREATE:
                $numbers = [1, 4, 6, 9];
                break;
            case self::CAN_UPDATE:
                $numbers = [3, 4, 8, 9];
                break;
            case self::CAN_DELETE:
                $numbers = [5, 6, 8, 9];
                break;
        }
        
        return in_array($permissionWeight, $numbers);
    }
    
    /**
     * See if a User have rights to access this api.
     *
     * 1. get user groups
     * 2. see if user group auth ref entry exists
     * 3. @TODO
     * 4. @TODO
     *
     * @param int    $userId
     * @param string $apiEndpoint As defined in the Module.php like (api-admin-user) which is a unique identifiere
     * @return boolena
	 */
    public function matchApi($userId, $apiEndpoint, $typeVerification = false)
    {
        UserOnline::refreshUser($userId, $apiEndpoint);
        //$groups = \yii::$app->db->createCommand("SELECT * FROM admin_group_auth as t1 LEFT JOIN (admin_group as t2 LEFT JOIN (admin_user as t3) ON (t2.user_id=t3.id)) ON (t1.group_id=t2.id) WHERE t3.id=:user_id")->bindValue(':user_id', $userId)->queryAll();
        $groups = Yii::$app->db->createCommand('SELECT * FROM admin_user_group AS t1 LEFT JOIN(admin_group_auth as t2 LEFT JOIN (admin_auth as t3) ON (t2.auth_id = t3.id)) ON (t1.group_id=t2.group_id) WHERE t1.user_id=:user_id AND t3.api=:api')
        ->bindValue('user_id', $userId)
        ->bindValue('api', $apiEndpoint)
        ->queryAll();

        if (!$typeVerification) {
            if (count($groups) > 0) {
                return true;
            }
            
            return false;
        }
        
        foreach($groups as $row) {
            if ($this->permissionVerify($typeVerification, $this->permissionWeight($row['crud_create'], $row['crud_update'], $row['crud_delete']))) {
                return true;
            }
        }
        
        return false;
    }
    /**
     * see if the user id matches against the moduleName, controllerName, actionName inside of the rights database.
     *
     * @param string $moduleName     Module Name
     * @param string $controllerName The name of the controller without suffix "Controller"
     * @param string $actionName     The name of the action without prefix "action";
     * @return bool
     */
    public function matchRoute($userId, $route)
    {
        UserOnline::refreshUser($userId, $route);
        //$groups = \yii::$app->db->createCommand("SELECT * FROM admin_group_auth as t1 LEFT JOIN (admin_group as t2 LEFT JOIN (admin_user as t3) ON (t2.user_id=t3.id)) ON (t1.group_id=t2.id) WHERE t3.id=:user_id")->bindValue(':user_id', $userId)->queryAll();
        $groups = Yii::$app->db->createCommand('SELECT * FROM admin_user_group AS t1 LEFT JOIN(admin_group_auth as t2 LEFT JOIN (admin_auth as t3) ON (t2.auth_id = t3.id)) ON (t1.group_id=t2.group_id) WHERE t1.user_id=:user_id AND t3.route=:route')
        ->bindValue('user_id', $userId)
        ->bindValue('route', $route)
        ->queryAll();

        if (empty($groups)) {
            return false;
        }

        if (count($groups) > 0) {
            return true;
        }

        return false;
    }

    public function addRoute($moduleName, $route, $name)
    {
        $handler = (new Query())->select('COUNT(*) AS count')->from('admin_auth')->where(['route' => $route])->one();
        if ($handler['count'] == 1) {
            Yii::$app->db->createCommand()->update('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
            ], ['route' => $route])->execute();
        } elseif ($handler['count'] == 0) {
            Yii::$app->db->createCommand()->insert('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
                'is_crud' => 0,
                'route' => $route,
                'api' => 0,
            ])->execute();
        } else {
            throw new Exception("Error while inserting/updating auth ROUTE '$route' with name '$name' in module '$moduleName'.");
        }
    }

    public function addApi($moduleName, $apiEndpoint, $name)
    {
        $handler = (new Query())->select('COUNT(*) AS count')->from('admin_auth')->where(['api' => $apiEndpoint])->one();
        if ($handler['count'] == 1) {
            Yii::$app->db->createCommand()->update('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
            ], ['api' => $apiEndpoint])->execute();
        } elseif ($handler['count'] == 0) {
            Yii::$app->db->createCommand()->insert('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
                'is_crud' => 1,
                'route' => 0,
                'api' => $apiEndpoint,
            ])->execute();
        } else {
            throw new Exception("Error while inserting/updating auth API '$apiEndpoint' with name '$name' in module '$moduleName'.");
        }
    }
    
    public function prepareCleanup(array $data)
    {
        $toCleanup = [];
        foreach($data as $type => $items) {
            switch($type) {
                case "apis":
                    $q = (new Query())->select('*')->from('admin_auth')->where(['not in', 'api', $items])->andWhere(['is_crud' => 1])->all();
                    $toCleanup = ArrayHelper::merge($q, $toCleanup);
                    break;
                case "routes":
                    $q = (new Query())->select('*')->from('admin_auth')->where(['not in', 'route', $items])->andWhere(['is_crud' => 0])->all();
                    $toCleanup = ArrayHelper::merge($q, $toCleanup);
                    break;
            }
        }
        return $toCleanup;
    }
    
    public function executeCleanup(array $data)
    {
        foreach($data as $rule) {
            Yii::$app->db->createCommand()->delete("admin_auth", 'id=:id', ['id' => $rule['id']])->execute();   
            Yii::$app->db->createCommand()->delete("admin_group_auth", 'auth_id=:id', ['id' => $rule['id']])->execute();
        }
    }

    /**
     * @todo remove me
     * @param array $apis
     */
    public function addApis(array $apis)
    {
        throw new \Exception('Deprecated method "addApis()".');
        /*
        foreach ($apis as $key => $value) {
            $this->addApi($key, $value);
        }
        */
    }
}
