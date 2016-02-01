<?php

namespace luya\traits;

use Yii;

/**
 * Cacheable trait to specific cache for yii components. 
 * 
 * Concret implementation example:
 * 
 * ```
 * $cacheKey = 'foobar';
 * 
 * $cache = $this->getHasCache($cacheKey);
 * 
 * if ($cache === false) {
 * 
 *     // execute code and save cache data into variable
 *     
 *     $this->setHasCache($cacheKey, $cache); // variable $cache has been changed from above
 * }
 * 
 * return $cache;
 * ```
 * 
 * @author nadar
 * @since 1.0.0-beta4
 */
trait CacheableTrait
{
    /**
     * @var boolean If enabled and the cache component is available the menu language containers will be
     * cached for the time defined in $cacheExpiration.
     */
    public $cacheEnabled = true;
    
    /**
     * @var integer Defined the duration of the caching lifetime in seconds. 3600 = 1 hour, 86400 = 24 hours.
     */
    public $cacheExpiration = 86400;

    /**
     * @var null|bollean store the cacheable state
     */
    private $_cachable = null;
    
    /**
     * Check if the current configuration of the application and the property allows a caching of the
     * language container data.
     *
     * @return boolean
     */
    public function isCachable()
    {
        if ($this->_cachable === null) {
            $this->_cachable = ($this->cacheEnabled && Yii::$app->has('cache')) ? true : false;
        }
    
        return $this->_cachable;
    }
    
    /**
     * Set the cache value if caching is allowed.
     *
     * @param string $key The identifier key
     * @param mix $value The value to store in the cache component.
     * @return void
     */
    public function setHasCache($key, $value)
    {
        if ($this->isCachable()) {
            Yii::$app->cache->set($key, $value, $this->cacheExpiration);
        }
    }
    
    /**
     * Remove a value from the cache if caching is enabled.
     * 
     * @param string $key The cache identifier
     */
    public function deleteHasCache($key)
    {
        if ($this->isCachable()) {
            Yii::$app->cache->delete($key);
        }
    }
    
    /**
     * Get the caching data if caching is allowed and there is any data stored for this key.
     *
     * @param string $key The identifiere key
     * @return mixed|boolean Returns the data, if not found returns false.
     */
    public function getHasCache($key)
    {
        if ($this->isCachable()) {
            $data = Yii::$app->cache->get($key);
            if ($data) {
                Yii::info("Cacheable trait key '$key' loaded from cache.", __METHOD__);
                return $data;
            }
            Yii::info("Cacheable trait key '$key' NOT loaded.", __METHOD__);
        }
    
        return false;
    }
}
