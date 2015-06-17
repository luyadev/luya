<?php

namespace admin\apis;

use Yii;

/**
 * @todo rename from auth to permission
 *
 * @author nadar
 */
class MenuController extends \admin\base\RestController
{
    private function getUserId()
    {
        return $this->getUser()->id;
    }

    private function getMenu()
    {
        return \luya\helpers\Param::get('adminMenus');
    }

    private function getNodeData($id)
    {
        $i = 1;
        foreach ($this->getMenu() as $item) {
            $i++;
            if ($id == $i) {
                $data = $item;
                break;
            }
        }

        return $data;
    }

    public function actionIndex()
    {
        $responseData = [];
        $index = 1;
        foreach ($this->getMenu() as $item) {
            $index++;
            // check if this is an entrie with a permission
            if ($item['permissionIsRoute']) {
                // verify if the permission is provided for this user:
                // if the permission is granted will write inti $responseData,
                // if not we continue;
                if (!Yii::$app->luya->auth->matchRoute($this->getUserId(), $item['permissionRoute'])) {
                    continue;
                }
            }

            // this item does have groups
            if (isset($item['groups'])) {
                $permissionGranted = false;

                // see if the groups has items
                foreach ($item['groups'] as $groupName => $groupItem) {
                    if (count($groupItem['items'])  > 0) {
                        if ($permissionGranted) {
                            continue;
                        }

                        foreach ($groupItem['items'] as $groupItemEntry) {
                            // a previous entry already has solved the question if the permission is granted
                            if ($permissionGranted) {
                                continue;
                            }
                            if ($groupItemEntry['permissionIsRoute']) {
                                // when true, set permissionGranted to true
                                if (Yii::$app->luya->auth->matchRoute($this->getUserId(), $groupItemEntry['route'])) {
                                    $permissionGranted = true;
                                }
                            } elseif ($groupItemEntry['permissionIsApi']) {
                                // when true, set permissionGranted to true
                                if (Yii::$app->luya->auth->matchApi($this->getUserId(), $groupItemEntry['permssionApiEndpoint'])) {
                                    $permissionGranted = true;
                                }
                            } else {
                                throw new \Exception('Menu item detected without permission entry');
                            }
                        }
                    }
                }

                if (!$permissionGranted) {
                    continue;
                }
            }

            // ok we have passed all the tests, lets make an entry
            $responseData[] = [
                'moduleId' => $item['moduleId'],
                'id' => $index,
                'template' => $item['template'],
                'routing' => $item['routing'],
                'alias' => $item['alias'],
                'icon' => $item['icon'],
            ];
        }

        return $responseData;
    }

    public function actionItems($nodeId)
    {
        $data = $this->getNodeData($nodeId);

        if (isset($data['groups'])) {
            foreach ($data['groups'] as $groupName => $groupItem) {
                foreach ($groupItem['items'] as $groupItemKey => $groupItemEntry) {
                    if ($groupItemEntry['permissionIsRoute']) {
                        // when true, set permissionGranted to true
                        if (!Yii::$app->luya->auth->matchRoute($this->getUserId(), $groupItemEntry['route'])) {
                            unset($data['groups'][$groupName]['items'][$groupItemKey]);
                        } else {
                            /* fixed bug #51 */
                            $data['groups'][$groupName]['items'][$groupItemKey]['route'] = str_replace("/", "-", $data['groups'][$groupName]['items'][$groupItemKey]['route']);
                        }
                    } elseif ($groupItemEntry['permissionIsApi']) {
                        // when true, set permissionGranted to true
                        if (!Yii::$app->luya->auth->matchApi($this->getUserId(), $groupItemEntry['permssionApiEndpoint'])) {
                            unset($data['groups'][$groupName]['items'][$groupItemKey]);
                        }
                    } else {
                        throw new \Exception('Menu item detected without permission entry');
                    }
                }
            }
        }

        return $data;
    }

    public function actionDashboard($nodeId)
    {
        $data = $this->getNodeData($nodeId);
        $accessList = [];
        
        foreach ($data['groups'] as $groupkey => $groupvalue) {
            foreach ($groupvalue['items'] as $row) {
                if ($row['permissionIsApi']) {
                    // @todo check if the user can access this api, otherwise hide this log informations?
                    $accessList[] = $row;
                }
            }
        }
        
        $log = [];
        foreach($accessList as $access) {
            $data = (new \yii\db\Query())->select(['timestamp_create', 'admin_ngrest_log.id', 'is_update', 'is_insert', 'admin_user.firstname', 'admin_user.lastname'])->from('admin_ngrest_log')->leftJoin('admin_user', 'admin_ngrest_log.user_id = admin_user.id')->orderBy('timestamp_create DESC')->where('api=:api and user_id!=0', [':api' => $access['permssionApiEndpoint']])->all();
            foreach($data as $row) {
                $date = mktime(0,0,0, date("n", $row['timestamp_create']), date("j", $row['timestamp_create']), date("Y", $row['timestamp_create']));
                $log[$date][$row['id']] = [
                    'name' => $row['firstname'] . " " . $row['lastname'],
                    'is_update' => $row['is_update'],
                    'is_insert' => $row['is_insert'],
                    'timestamp' => $row['timestamp_create'],
                    'alias' => $access['alias'],
                    'icon' => $access['icon'],
                ];
            }
        }
        
        
        $array = [];
        
        foreach($log as $day => $values) {
            $array[] = [
                'day' => $day,
                'items' => $values,
            ];
        }
        
        return $array;
    }
}
