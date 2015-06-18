<?php

namespace admin\components;

use \admin\models\UserOnline;

class Auth extends \yii\base\Component
{
    /**
     * on luya component registration.
     */
    public function init()
    {
    }

    /**
     * See if a User have rights to access this api.
     *
     * 1. get user groups
     * 2. see if user group auth ref entry exists
     * 3. return the entrys crud information
     * 4. get the most priority high crud type (create+update+delete = 3)
     * 5. return
     *
     * @param int    $userId
     * @param string $apiEndpoint As defined in the Module.php like (api-admin-user) which is a unique identifiere
     */
    public function matchApi($userId, $apiEndpoint)
    {
        UserOnline::refreshUser($userId, $apiEndpoint);
        $db = \yii::$app->db;
        //$groups = \yii::$app->db->createCommand("SELECT * FROM admin_group_auth as t1 LEFT JOIN (admin_group as t2 LEFT JOIN (admin_user as t3) ON (t2.user_id=t3.id)) ON (t1.group_id=t2.id) WHERE t3.id=:user_id")->bindValue(':user_id', $userId)->queryAll();
        $groups = $db->createCommand('SELECT * FROM admin_user_group AS t1 LEFT JOIN(admin_group_auth as t2 LEFT JOIN (admin_auth as t3) ON (t2.auth_id = t3.id)) ON (t1.group_id=t2.group_id) WHERE t1.user_id=:user_id AND t3.api=:api')
        ->bindValue('user_id', $userId)
        ->bindValue('api', $apiEndpoint)
        ->queryAll();

        $lastPrio = 0;
        $lastItem = 0;
        foreach ($groups as $item) {
            $prio = $item['crud_create'] + $item['crud_update'] + $item['crud_delete'];
            if ($prio >= $lastPrio) {
                $lastItem = $item;
            }
        }

        if (!empty($lastItem)) {
            return true;
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
        UserOnline::refreshUser($userId, $route);
        $db = \yii::$app->db;
        //$groups = \yii::$app->db->createCommand("SELECT * FROM admin_group_auth as t1 LEFT JOIN (admin_group as t2 LEFT JOIN (admin_user as t3) ON (t2.user_id=t3.id)) ON (t1.group_id=t2.id) WHERE t3.id=:user_id")->bindValue(':user_id', $userId)->queryAll();
        $groups = $db->createCommand('SELECT * FROM admin_user_group AS t1 LEFT JOIN(admin_group_auth as t2 LEFT JOIN (admin_auth as t3) ON (t2.auth_id = t3.id)) ON (t1.group_id=t2.group_id) WHERE t1.user_id=:user_id AND t3.route=:route')
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
        $handler = (new \yii\db\Query())->select('COUNT(*) AS count')->from('admin_auth')->where(['route' => $route])->one();
        if ($handler['count'] == 1) {
            \yii::$app->db->createCommand()->update('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
            ], ['route' => $route])->execute();
        } elseif ($handler['count'] == 0) {
            \yii::$app->db->createCommand()->insert('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
                'is_crud' => 0,
                'route' => $route,
                'api' => 0,
            ])->execute();
        } else {
            throw new \Exception('error while making admin_auth route insert/update, the key exists twice in the databse!');
        }
    }

    public function addApi($moduleName, $apiEndpoint, $name)
    {
        $handler = (new \yii\db\Query())->select('COUNT(*) AS count')->from('admin_auth')->where(['api' => $apiEndpoint])->one();
        if ($handler['count'] == 1) {
            \yii::$app->db->createCommand()->update('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
            ], ['api' => $apiEndpoint])->execute();
        } elseif ($handler['count'] == 0) {
            \yii::$app->db->createCommand()->insert('admin_auth', [
                'alias_name' => $name,
                'module_name' => $moduleName,
                'is_crud' => 1,
                'route' => 0,
                'api' => $apiEndpoint,
            ])->execute();
        } else {
            throw new \Exception('error while making admin_auth api insert/update, the key exists twice in the databse!');
        }
    }

    public function addApis(array $apis)
    {
        foreach ($apis as $key => $value) {
            $this->addApi($key, $value);
        }
    }
}
