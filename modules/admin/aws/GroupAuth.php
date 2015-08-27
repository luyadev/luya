<?php

namespace admin\aws;

class GroupAuth extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'admin';

    public function index()
    {
        $query = (new \yii\db\Query())->select('*')->from('admin_group_auth')->where(['group_id' => $this->getItemId()])->all();

        $subs = [];

        foreach ($query as $item) {
            $subs[$item['auth_id']] = [
                'base' => 1,
                'create' => $item['crud_create'],
                'update' => $item['crud_update'],
                'delete' => $item['crud_delete'],
            ];
        }

        return $this->render('index', [
            'groupId' => $this->getItemId(),
            'auth' => (new \yii\db\Query())->select('*')->from('admin_auth')->orderBy('module_name, alias_name ASC')->all(),
            'subs' => $subs,
        ]);
    }

    public function callbackUpdateSubscription()
    {
        $rights = \yii::$app->request->post('rights', []);

        $safeCopy = [];
        foreach ($rights as $authId => $options) {
            if (!isset($options['base'])) {
                return $this->response(false, ['message' => 'you have to select at least the ANZEIGEN value.']);
            }
            $safeCopy[$authId] = $options;
        }

        // remove all group auth
        \yii::$app->db->createCommand()->delete('admin_group_auth', ['group_id' => $this->getItemId()])->execute();

        foreach ($safeCopy as $authId => $options) {
            \yii::$app->db->createCommand()->insert('admin_group_auth', [
                'group_id' => $this->getItemId(),
                'auth_id' => $authId,
                'crud_create' => (isset($options['create'])) ? 1 : 0,
                'crud_update' => (isset($options['update'])) ? 1 : 0,
                'crud_delete' => (isset($options['delete'])) ? 1 : 0,
            ])->execute();
        }

        return $this->response(true, ['message' => 'well done']);
    }
}
