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
 * Synchronise a PROD env to your locale env with files and images.
 *
 * The proxy command will ask for an url, identifier and token. The url is the url of your website in production where you have leased the token and
 * identifier inside the admin. Make sure you are using the right protocol (with or without https)!
 *
 * e.g url: `https://luya.io` or if you are using a domain with www `http://www.example.com` depending on your server configuration.
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy
 * ```
 *
 * You can also provide all prompted options in order to not used an interactive mode:
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy --url=https://example.com --idf=lcp58e35acb4ca69 --token=ESOH1isB3ka_dF09ozkDJewpeecGCdUw
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
 * ./vendor/bin/luya admin/proxy --strict=0 --table=large_table,another_table
 * ```
 *
 * which is equals to:
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy -s=0 -t=large_table
 * ```
 *
 * Using wildcard to use table with a given prefix use:
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy -t=app_*
 * ```
 *
 * would only sync tables which starts with `app_*` like `app_news`, `app_articles`.
 *
 * In order to clear the proxy config run:
 *
 * ```sh
 * ./vendor/bin/luya admin/proxy/clear
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
     * the exception message you can disable the strict compare mode. In order to ensure strict comparing enable $strict.
     */
    public $strict = false;
    
    /**
     * @var string If a table option is passed only this table will be synchronised. If false by default all tables will be synced. You
     * can define multible tables ab seperating those with a comma `table1,table2,table`. In order to define only tables with start
     * with a given prefix you can use `app_*` using asterisks symbold to define wild card starts with string defintions.
     */
    public $table;
    
    /**
     * @var string The production environment Domain where your LUYA application is running in production mode make so to use the right protocolo
     * examples:
     * - https://luya.io
     * - http://www.example.com
     *
     */
    public $url;
    
    /**
     * @var string The identifier you get from the Machines menu in your production env admin looks like this: lcp58e35acb4ca69
     */
    public $idf;

    /**
     * @var string The token which is used for the identifier, looks like this: ESOH1isB3ka_dF09ozkDJewpeecGCdUw
     */
    public $token;
    
    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['strict', 'table', 'url', 'idf', 'token']);
    }
    
    /**
     * @inheritdoc
     */
    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), ['s' => 'strict', 't' => 'table', 'u' => 'url', 'i' => 'idf', 'tk' => 'token']);
    }
    
    /**
     * Sync Proxy Data.
     *
     * @return number
     */
    public function actionSync()
    {
        if ($this->url === null) {
            $url = Config::get(self::CONFIG_VAR_URL);
            
            if (!$url) {
                $url = $this->prompt('Enter the Proxy PROD env URL (e.g. https://example.com):');
                Config::set(self::CONFIG_VAR_URL, $url);
            }
        } else {
            $url = $this->url;
        }
        
        if ($this->idf === null) {
            $identifier = Config::get(self::CONFIG_VAR_IDENTIFIER);
            
            if (!$identifier) {
                $identifier = $this->prompt('Please enter the identifier ID:');
                Config::set(self::CONFIG_VAR_IDENTIFIER, trim($identifier));
            }
        } else {
            $identifier = $this->idf;
        }
        
        if ($this->token === null) {
            $token = Config::get(self::CONFIG_VAR_TOKEN);
            
            if (!$token) {
                $token = $this->prompt('Please enter the access token:');
                Config::set(self::CONFIG_VAR_TOKEN, trim($token));
            }
        } else {
            $token = $this->token;
        }
        
        
        $proxyUrl = Url::ensureHttp(rtrim(trim($url), '/')) . '/admin/api-admin-proxy';
        $this->outputInfo('Connect to: ' . $proxyUrl);
        
        $curl = new Curl();
        $curl->get($proxyUrl, ['identifier' => $identifier, 'token' => sha1($token)]);
        
        if (!$curl->error) {
            $this->flushHasCache();
            
            $this->verbosePrint($curl->response);
            
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
                // as the admin_config table is synced to, we have to restore the current active config which has been used.
                Config::set(self::CONFIG_VAR_IDENTIFIER, $identifier);
                Config::set(self::CONFIG_VAR_TOKEN, $token);
                Config::set(self::CONFIG_VAR_URL, $url);
                
                return $this->outputSuccess('Sync process has been successfully finished.');
            }
        }
        
        $this->clearConfig();
        $this->output($curl->response);
        return $this->outputError($curl->error_message);
    }

    private function clearConfig()
    {
        Config::remove(self::CONFIG_VAR_TOKEN);
        Config::remove(self::CONFIG_VAR_URL);
        Config::remove(self::CONFIG_VAR_IDENTIFIER);
    }
    
    /**
     * Cleanup all stored Config Data.
     *
     * @return number
     */
    public function actionClear()
    {
        $this->clearConfig();
        return $this->outputSuccess('Config has been cleared.');
    }
}
