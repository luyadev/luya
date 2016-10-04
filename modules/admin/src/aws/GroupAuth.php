<?php

namespace luya\admin\aws;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Active Window to set permissions for a specific Group, used in groups ngrest model.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class GroupAuth extends ActiveWindow
{
    public $module = 'admin';

    public $icon = 'verified_user';
    
    public function index()
    {
        return $this->render('index');
    }

    public function callbackSaveRights()
    {
        $rights = Yii::$app->request->post('data', []);

        $safeCopy = [];

        foreach ($rights as $authId => $options) {
            if (!empty($options) && isset($options['base']) && $options['base'] == 1) {
                $safeCopy[$authId] = $options;
            }
        }

        Yii::$app->db->createCommand()->delete('admin_group_auth', ['group_id' => $this->getItemId()])->execute();

        foreach ($safeCopy as $authId => $options) {
            Yii::$app->db->createCommand()->insert('admin_group_auth', [
                'group_id' => $this->getItemId(),
                'auth_id' => $authId,
                'crud_create' => (isset($options['create']) && $options['create'] == 1) ? 1 : 0,
                'crud_update' => (isset($options['update']) && $options['update'] == 1) ? 1 : 0,
                'crud_delete' => (isset($options['delete']) && $options['delete'] == 1) ? 1 : 0,
            ])->execute();
        }

        return ['success' => true];
    }

    public function callbackGetRights()
    {
        return [
            'rights' => $this->getRightsData(),
            'auths' => $this->getAuthData(),
        ];
    }

    private function getAuthData()
    {
        $data = (new \yii\db\Query())->select('*')->from('admin_auth')->orderBy('module_name, alias_name ASC')->all();
        $last = false;
        foreach ($data as $k => $v) {
            $data[$k]['is_head'] = ($last !== $v['module_name']) ? 1 : 0;
            $data[$k]['group_alias'] = ucfirst($v['module_name']);
            $last = $v['module_name'];
        }

        return $data;
    }

    private function getRightsData()
    {
        $query = (new \yii\db\Query())->select('*')->from('admin_group_auth')->where(['group_id' => $this->getItemId()])->all();

        $subs = [];

        foreach ($query as $item) {
            $subs[$item['auth_id']] = [
                'base' => 1,
                'create' => (int) $item['crud_create'],
                'update' => (int) $item['crud_update'],
                'delete' => (int) $item['crud_delete'],
            ];
        }

        return $subs;
    }
}
