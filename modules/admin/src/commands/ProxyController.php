<?php

namespace luya\admin\commands;

use Curl\Curl;
use yii\helpers\Json;
use luya\admin\models\Config;
use luya\admin\proxy\ClientBuild;
use luya\admin\proxy\ClientTransfer;
use luya\traits\CacheableTrait;
use luya\helpers\Url;
use luya\console\Command;

/**
 * Proxy Sync Command.
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy
 * ```
 *
 * Options:
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy --strict=0
 * ./vendor/bin/luya admin/proxy --table=admin_user
 * ```
 *
 * For example in order to sync a large table without strict compare check
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy --strict=0 --table=large_table
 * ```
 *
 * which is equals to:
 *
  * ```sh
 * ./vendor/bin/luya admin/proxy -s=0 -t=large_table
 * ```
 *
 * In order to clear the proxy config run
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy/clear
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ProxyController extends Command
{
    use CacheableTrait;
    
    const CONFIG_VAR_URL = 'lcpProxyUrl';
    
    const CONFIG_VAR_TOKEN = 'lcpProxyToken';
    
    const CONFIG_VAR_IDENTIFIER = 'lcpProxyIdentifier';
    
    /**
     * @inheritdoc
     */
    public $defaultAction = 'sync';
    
    /**
     * @var boolean Whether the isComplet sync check should be done after finish or not. If a table has a lot of traffic sometimes
     * there is a difference between the exchange of table informations (build) and transfer the data. In order to prevent
     * the exception message you can disable the strict compare mode.
     */
    public $strict = true;
    
    /**
     * @var string If a table option is passed only this table will be synchronised. If false by default all tables will be synced.
     */
    public $table = null;
    
    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return ['strict', 'table'];
    }
    
    /**
     * @inheritdoc
     */
    public function optionAliases()
    {
        return ['s' => 'strict', 't' => 'table'];
    }
    
    /**
     * Sync Proxy Data.
     *
     * @return number
     */
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
        
        $proxyUrl = Url::ensureHttp(rtrim($url, '/')) . '/admin/api-admin-proxy';
        $this->outputInfo('Connect to: ' . $proxyUrl);
        
        $curl = new Curl();
        $curl->get($proxyUrl, ['identifier' => $identifier, 'token' => sha1($token)]);
        
        if (!$curl->error) {
            $this->flushHasCache();
            $response = Json::decode($curl->response);
            $build = new ClientBuild($this, [
                'optionStrict' => $this->strict,
                'optionTable' => $this->table,
                'buildToken' => sha1($response['buildToken']),
                'buildConfig' => $response['config'],
                'requestUrl' => $response['providerUrl'],
                'requestCloseUrl' => $response['requestCloseUrl'],
                'fileProviderUrl' => $response['fileProviderUrl'],
                'imageProviderUrl' => $response['imageProviderUrl'],
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
    
    /**
     * Cleanup all stored Config Data.
     *
     * @return number
     */
    public function actionClear()
    {
        Config::remove(self::CONFIG_VAR_TOKEN);
        Config::remove(self::CONFIG_VAR_URL);
        Config::remove(self::CONFIG_VAR_IDENTIFIER);
        return $this->outputSuccess('Config has been cleared.');
    }
}
