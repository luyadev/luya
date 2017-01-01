<?php

namespace luya\admin\commands;

use luya\admin\models\Config;
use Curl\Curl;
use yii\helpers\Json;
use luya\admin\proxy\ClientBuild;
use luya\admin\proxy\ClientTransfer;

class ProxyController extends \luya\console\Command
{
    const CONFIG_VAR_URL = 'lcpProxyUrl';
    
    const CONFIG_VAR_TOKEN = 'lcpProxyToken';
    
    const CONFIG_VAR_IDENTIFIER = 'lcpProxyIdentifier';
    
    public function actionSync()
    {
        $url = Config::get(self::CONFIG_VAR_URL);
        
        if (!$url) {
            $url = $this->prompt('Please enter the lcp Proxy Url:');
            Config::set(self::CONFIG_VAR_URL, $url);
        }
        
        $identifier = Config::get(self::CONFIG_VAR_IDENTIFIER);
        
        if (!$identifier) {
            $identifier = $this->prompt('Please enter the identifier ID:');
            Config::set(self::CONFIG_VAR_IDENTIFIER, $identifier);
        }
        
        $token = Config::get(self::CONFIG_VAR_TOKEN);
        
        if (!$token) {
            $token = $this->prompt('Please enter the access token:');
            Config::set(self::CONFIG_VAR_TOKEN, $token);
        }
        
        $proxyUrl = rtrim($url, '/') . '/admin/api-admin-proxy';
        $this->outputInfo('Connect to: ' . $proxyUrl);
        
        $curl = new Curl();
        $curl->get($proxyUrl, ['identifier' => $identifier, 'token' => sha1($token)]);
        
        if (!$curl->error) {
            $response = Json::decode($curl->response);
            $build = new ClientBuild($this, [
                'buildToken' => sha1($response['buildToken']),
                'buildConfig' => $response['config'],
                'requestUrl' => $response['providerUrl'],
                'requestCloseUrl' => $response['requestCloseUrl'],
                'fileProviderUrl' => $response['fileProviderUrl'],
                'machineIdentifier' => $identifier,
                'machineToken' => sha1($token),
            ]);
            
            $process = new ClientTransfer(['build' => $build]);
            if ($process->start()) {
                return $this->outputSuccess('sync process has been sucessfull finished.');
            }
        }
        
        $this->output($curl->response);
        return $this->outputError($curl->error_message);
    }
    
    public function actionClear()
    {
        Config::remove(self::CONFIG_VAR_TOKEN);
        Config::remove(self::CONFIG_VAR_URL);
        Config::remove(self::CONFIG_VAR_IDENTIFIER);
        return $this->outputSuccess('Config has been cleared.');
    }
}
