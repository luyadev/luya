<?php

namespace luya\admin\components;

use Yii;
use Exception;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Auth components gives informations about permissions, who can do what.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Auth extends \yii\base\Component
{
    const CAN_CREATE = 1;

    const CAN_UPDATE = 2;

    const CAN_DELETE = 3;

    private $_permissionTable = null;
    
    /**
     * Get Permision from sql table by userId
     *
     * @param integer $userId
     * @return array
     */
    private function getPermissionTable($userId)
    {
        if ($this->_permissionTable === null) {
            $this->_permissionTable = Yii::$app->db->createCommand('SELECT * FROM admin_user_group AS t1 LEFT JOIN(admin_group_auth as t2 LEFT JOIN (admin_auth as t3) ON (t2.auth_id = t3.id)) ON (t1.group_id=t2.group_id) WHERE t1.user_id=:user_id')
            ->bindValue('user_id', $userId)
            ->queryAll();
        }
        
        return $this->_permissionTable;
    }
    
    public function getApiTable($userId, $apiEndpoint)
    {
        $data = [];
        foreach ($this->getPermissionTable($userId) as $item) {
            if ($item['api'] == $apiEndpoint) {
                $data[] = $item;
            }
        }
        return $data;
    }
    
    public function getRouteTable($userId, $route)
    {
        $data = [];
        foreach ($this->getPermissionTable($userId) as $item) {
            if ($item['route'] == $route) {
                $data[] = $item;
            }
        }
        return $data;
    }
    
    public function permissionWeight($create, $update, $delete)
    {
        $create = $create ? 1 : 0;
        $update = $update ? 3 : 0;
        $delete = $delete ? 5 : 0;

        return ($create + $update + $delete);
    }

    public function permissionVerify($type, $permissionWeight)
    {
        $numbers = [];
        
        switch ($type) {
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
     * @param int    $userId
     * @param string $apiEndpoint      As defined in the Module.php like (api-admin-user) which is a unique identifiere
     * @param int    $typeVerification The CONST number provided from CAN_*
     *
     * @return bool
     */
    public function matchApi($userId, $apiEndpoint, $typeVerification = false)
    {
        $groups = $this->getApiTable($userId, $apiEndpoint);

        if ($typeVerification === false) {
            return (count($groups) > 0) ? true : false;
        }

        foreach ($groups as $row) {
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
     *
     * @return bool
     */
    public function matchRoute($userId, $route)
    {
        $groups = $this->getRouteTable($userId, $route);
        
        if (is_array($groups) && count($groups) > 0) {
            return true;
        }

        return false;
    }

    public function addRoute($moduleName, $route, $name)
    {
        $handler = (new Query())->select('COUNT(*) AS count')->from('admin_auth')->where(['route' => $route])->one();
        if ($handler['count'] == 1) {
            return Yii::$app->db->createCommand()->update('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
            ], ['route' => $route])->execute();
        } elseif ($handler['count'] == 0) {
            return Yii::$app->db->createCommand()->insert('admin_auth', [
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
            return Yii::$app->db->createCommand()->update('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
            ], ['api' => $apiEndpoint])->execute();
        } elseif ($handler['count'] == 0) {
            return Yii::$app->db->createCommand()->insert('admin_auth', [
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

    /**
     * Returns the current available auth rules inside the admin_auth table splied into routes and apis.
     *
     * @return array
     */
    public function getDatabaseAuths()
    {
        // define response structure of array
        $data = [
            'routes' => [],
            'apis' => [],
        ];
        // get all auth data
        foreach ((new Query())->select('*')->from('admin_auth')->all() as $item) {
            // allocate if its an api or route. More differences?
            if (empty($item['api'])) {
                $data['routes'][] = $item;
            } else {
                $data['apis'][] = $item;
            }
        }

        return $data;
    }

    /**
     * The method returns all rows which are not provided in $array. If an api/route is in the $data array its a valid rule and will not be
     * prepared to find for deletion. Negativ array behavior.
     *
     * ```php
     * $data = [
     *     'apis' => ['api-admin-test', 'api-admin-foo'],
     *     'routes' => ['route-to-sth', 'foo-bar-bar'],
     * ];
     * ```
     *
     * The above provided data are valid rules.
     *
     * @param array $data array with key apis and routes
     *
     * @return array
     */
    public function prepareCleanup(array $data)
    {
        $toCleanup = [];
        foreach ($data as $type => $items) {
            switch ($type) {
                case 'apis':
                    $q = (new Query())->select('*')->from('admin_auth')->where(['not in', 'api', $items])->andWhere(['is_crud' => 1])->all();
                    $toCleanup = ArrayHelper::merge($q, $toCleanup);
                    break;
                case 'routes':
                    $q = (new Query())->select('*')->from('admin_auth')->where(['not in', 'route', $items])->andWhere(['is_crud' => 0])->all();
                    $toCleanup = ArrayHelper::merge($q, $toCleanup);
                    break;
            }
        }

        return $toCleanup;
    }

    /**
     * Execute the data to delete based on an array containing a key 'id' with the corresponding value from the Database.
     *
     * @param array $data
     *
     * @return bool
     */
    public function executeCleanup(array $data)
    {
        foreach ($data as $rule) {
            Yii::$app->db->createCommand()->delete('admin_auth', 'id=:id', ['id' => $rule['id']])->execute();
            Yii::$app->db->createCommand()->delete('admin_group_auth', 'auth_id=:id', ['id' => $rule['id']])->execute();
        }

        return true;
    }
}
