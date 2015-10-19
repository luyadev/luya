<?php

namespace admin\aws;

use Yii;

class GroupAuth extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'admin';

    public function index()
    {
        return $this->render('index', [
            'groupId' => $this->getItemId(),
            'auth' => $this->getAuthData(),
            'subs' => $this->getRightsData(),
        ]);
    }
    
    public function callbackSaveRights()
    {
        $rights = Yii::$app->request->post('data', []);
        
        $safeCopy = [];
        
        foreach($rights as $authId => $options) {
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
        return (new \yii\db\Query())->select('*')->from('admin_auth')->orderBy('module_name, alias_name ASC')->all();
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

    /*
    public function callbackUpdateSubscription()
    {
        $rights = Yii::$app->request->post('rights', []);

        $safeCopy = [];
        foreach ($rights as $authId => $options) {
            if (!isset($options['base'])) {
                return $this->response(false, ['message' => 'you have to select at least the ANZEIGEN value.']);
            }
            $safeCopy[$authId] = $options;
        }

        // remove all group auth
        Yii::$app->db->createCommand()->delete('admin_group_auth', ['group_id' => $this->getItemId()])->execute();

        foreach ($safeCopy as $authId => $options) {
            Yii::$app->db->createCommand()->insert('admin_group_auth', [
                'group_id' => $this->getItemId(),
                'auth_id' => $authId,
                'crud_create' => (isset($options['create'])) ? 1 : 0,
                'crud_update' => (isset($options['update'])) ? 1 : 0,
                'crud_delete' => (isset($options['delete'])) ? 1 : 0,
            ])->execute();
        }

        return $this->response(true, ['message' => 'well done']);
    }
    */
}
