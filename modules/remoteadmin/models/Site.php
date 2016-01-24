<?php

namespace remoteadmin\models;

use Yii;
use luya\helpers\Url;

class Site extends \admin\ngrest\base\Model
{
    /* yii model properties */

    public static function tableName()
    {
        return 'remote_site';
    }

    public function rules()
    {
        return [
            [['token', 'url'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['token', 'url', 'auth_is_enabled', 'auth_user', 'auth_pass'],
            'restupdate' => ['token', 'url', 'auth_is_enabled', 'auth_user', 'auth_pass'],
        ];
    }

    /* ngrest model properties */

    public function genericSearchFields()
    {
        return ['token', 'url'];
    }

    public function ngRestApiEndpoint()
    {
        return 'api-remote-site';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('token', 'Token')->text();
        $config->list->field('url', 'Url')->text();
        $config->list->field('auth_is_enabled', 'Verwendet Authentifizierung?')->toggleStatus();
        $config->create->copyFrom('list');
        $config->create->field('auth_user', 'Auth Benutzer')->text();
        $config->create->field('auth_pass', 'Auth Passwort')->text();
        $config->update->copyFrom('create');
        $config->delete = true;
        return $config;
    }
    
    /* custom methods */
    
    public function getRemote()
    {
        $url = Url::trailing($this->url);
        
        $data = Yii::$app->cache->get($url);
        
        if ($data === false) {
            
            $curl = new \Curl\Curl();
            
            if ($this->auth_is_enabled) {
                $curl->setBasicAuthentication($this->auth_user, $this->auth_pass);
            }
            
            $curl->get($url . 'admin/api-admin-remote?token=' . sha1($this->token));
            if ($curl->error) {
                $data = false;
            } else {
                $data = json_decode($curl->response, true);
            }
            
            Yii::$app->cache->set($url, $data, (60*2));
        }
        
        return $data;
    }
}