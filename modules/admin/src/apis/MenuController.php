<?php

namespace luya\admin\apis;

use Yii;
use luya\admin\Module;
use luya\admin\base\RestController;
use luya\admin\models\UserOnline;

/**
 * Admin Menu API, provides all menu items and dashabord informations for a node or the entire system.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class MenuController extends RestController
{
    /**
     * The index action of the menu api returns all available modules which is the top menu know as node.
     *
     * @return array
     */
    public function actionIndex()
    {
        return Yii::$app->adminmenu->getModules();
    }

    /**
     * The items action returns all items for a given node.
     *
     * @param integer $nodeId The id of the node to find all items from.
     * @return array
     */
    public function actionItems($nodeId)
    {
        UserOnline::unlock(Yii::$app->adminuser->id);
        return Yii::$app->adminmenu->getModuleItems($nodeId);
    }

    /**
     * Get all dashabord items for a given node.
     *
     * @param integer $nodeId The id of the node to find all items from.
     * @return array
     */
    public function actionDashboard($nodeId)
    {
        $data = Yii::$app->adminmenu->getNodeData($nodeId);
        $accessList = [];

        // verify if no permissions has ben seet for this know or no groups are available trough permissions issues.
        if (!isset($data['groups'])) {
            return [];
        }
        
        foreach ($data['groups'] as $groupkey => $groupvalue) {
            foreach ($groupvalue['items'] as $row) {
                if ($row['permissionIsApi']) {
                    try {
                        $row['alias'] = Yii::t($data['moduleId'], $row['alias'], [], Yii::$app->language);
                    } catch (\Exception $e) {
                    }
                    $accessList[] = $row;
                }
            }
        }

        $log = [];
        foreach ($accessList as $access) {
            $data = (new \yii\db\Query())->select(['timestamp_create', 'user_id', 'admin_ngrest_log.id', 'is_update', 'is_insert', 'admin_user.firstname', 'admin_user.lastname'])->from('admin_ngrest_log')->leftJoin('admin_user', 'admin_ngrest_log.user_id = admin_user.id')->orderBy('timestamp_create DESC')->limit(30)->where('api=:api and user_id!=0', [':api' => $access['permssionApiEndpoint']])->all();
            foreach ($data as $row) {
                $date = mktime(0, 0, 0, date('n', $row['timestamp_create']), date('j', $row['timestamp_create']), date('Y', $row['timestamp_create']));
                $log[$date][] = [
                    'name' => $row['firstname'].' '.$row['lastname'],
                    'is_update' => $row['is_update'],
                    'is_insert' => $row['is_insert'],
                    'timestamp' => $row['timestamp_create'],
                    'alias' => $access['alias'],
                    'message' => ($row['is_update']) ? Module::t('dashboard_log_message_edit', ['container' => $access['alias']]) : Module::t('dashboard_log_message_add', ['container' => $access['alias']]),
                    'icon' => $access['icon'],
                ];
            }
        }

        $array = [];

        krsort($log, SORT_NUMERIC);

        foreach ($log as $day => $values) {
            $array[] = [
                'day' => $day,
                'items' => $values,
            ];
        }

        return $array;
    }
}
