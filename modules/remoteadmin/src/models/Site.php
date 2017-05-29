<?php

namespace luya\remoteadmin\models;

use yii\helpers\Json;
use Curl\Curl;
use luya\helpers\Url;
use luya\traits\CacheableTrait;
use luya\admin\ngrest\base\NgRestModel;
use luya\remoteadmin\Module;

/**
 * This is the model class for table "remote_site".
 *
 * @property integer $id
 * @property string $token
 * @property string $url
 * @property integer $auth_is_enabled
 * @property string $auth_user
 * @property string $auth_pass
 */
class Site extends NgRestModel
{
	use CacheableTrait;

	/**
	 * @inheritdoc
	 */
    public static function tableName()
    {
        return 'remote_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    		[['token', 'url'], 'required'],
    		[['auth_is_enabled'], 'integer'],
    		[['token', 'url', 'auth_user', 'auth_pass'], 'string', 'max' => 120],
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
    		'id' => Module::t('model_site_id'),
    		'token' => Module::t('model_site_token'),
    		'url' => Module::t('model_site_url'),
    		'auth_is_enabled' => Module::t('model_site_auth_is_enabled'),
    		'auth_user' => Module::t('model_site_auth_user'),
    		'auth_pass' => Module::t('model_site_auth_pass'),
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['url'];
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-remote-site';
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
    	return [
    		'token' => 'text',
    		'url' => 'text',
    		'auth_is_enabled' => 'toggleStatus',
    		'auth_user' => 'text',
    		'auth_pass' => 'password',
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
    	return [
    		['list', ['url', 'token']],
    		[['create', 'update'], ['url', 'token', 'auth_is_enabled', 'auth_user', 'auth_pass']],
    		['delete', true],
    	];
    }
    
    /**
     * Ensure the input URL.
     * 
     * @return string
     */
    public function getEnsuredUrl()
    {
    	return Url::ensureHttp(Url::trailing($this->url));
    }
    
    public function extraFields()
    {
    	return ['remote'];
    }
    
    /**
     * Get the remote data.
     * 
     * @return array|boolean
     */
    public function getRemote()
    {
    	return $this->getOrSetHasCache([__CLASS__, $this->getEnsuredUrl()], function() {
        	$curl = new Curl();
        	if ($this->auth_is_enabled) {
        		$curl->setBasicAuthentication($this->auth_user, $this->auth_pass);
        	}
        	$curl->get($this->getEnsuredUrl(). 'admin/api-admin-remote?token=' . sha1($this->token));

        	$data = $curl->isSuccess() ? Json::decode($curl->response) : false;
        	
        	if ($data) {
        		$data['app_elapsed_time'] = round($data['app_elapsed_time'], 2);
        		$data['app_debug_style'] = $this->colorize($data['app_debug'], true);
        		$data['app_debug'] = $this->textify($data['app_debug']);
        		$data['app_transfer_exceptions_style'] = $this->colorize($data['app_transfer_exceptions']);
        		$data['app_transfer_exceptions'] = $this->textify($data['app_transfer_exceptions']);
        		$data['luya_version_style'] = $this->versionize($data['luya_version']);
        		$data['error'] = false;
        	} else {
        		$data['error'] = true;
        	}
        	
        	return $data;
        }, (60*2));
    }
    
    public function textify($value)
    {
        return !empty($value) ? Module::t('model_site_on') :  Module::t('model_site_off') ;
    }
    
    public function colorize($value, $invert = false)
    {
    	if ($invert) {
    		$state = empty($value);
    	} else {
    		$state = !empty($value);
    	}
    	return $state ? 'background-color:#c8e6c9' : 'background-color:#ffcdd2';
    }
    
    public function versionize($version)
    {
    	return ($version == self::getCurrentLuyaVersion()['version']) ? 'background-color:#c8e6c9' : 'background-color:#ffcdd2';
    }
    
    private static $_currentVersion;
    
    public static function getCurrentLuyaVersion()
    {
    	if (self::$_currentVersion !== null) {
    		return self::$_currentVersion;
    	}
    	
    	$curl = new Curl();
    	$curl->get('https://packagist.org/packages/luyadev/luya-core.json');
    	$json = Json::decode($curl->response);
    		
    		foreach ($json['package']['versions'] as $version =>  $package) {
    			if ($version == 'dev-master' || !is_numeric(substr($version, 0, 1))) {
    				continue;
    			}
    			
    			self::$_currentVersion= $package;
    			return $package;
    		}
    		
    		return false;
    }
}
