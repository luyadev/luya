<?php

namespace luya\traits;

use Yii;

/**
 * Cacheable trait to specific cache for yii components. 
 * 
 * Concret implementation example:
 * 
 * ```php
 * $cacheKey = 'foobar';
 * 
 * $cache = $this->getHasCache($cacheKey);
 * 
 * if ($cache === false) {
 * 
 *     // execute code and save cache data into variable
 *     $cache = "Hello World";
 *     
 *     $this->setHasCache($cacheKey, $cache); // variable $cache has been changed from above
 * }
 * 
 * return $cache;
 * ```
 * 
 * An example for a simple cache query dependency
 * 
 * ```php
 * $this->setHasCache('myCacheKey', $folders, new DbDependency(['sql' => 'SELECT MAX(id) FROM admin_storage_folder WHERE is_deleted=0']), 0);
 * ```
 * 
 * @author nadar
 * @since 1.0.0-beta4
 */
trait CacheableTrait
{
    /**
     * @var boolean If enabled and the cache component is available. If disabled it will fully ignore the any caching but
     * does not throw exception.
     */
    public $cacheEnabled = true;
    
    /**
     * @var integer Defined the duration of the caching lifetime in seconds. 3600 = 1 hour, 86400 = 24 hours. 0 is forever
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
     * @param mixed $value The value to store in the cache component.
     * @param \yii\caching\Dependency $dependency Dependency of the cached item. If the dependency changes, the corresponding value in the cache will be invalidated when it is fetched via get(). This parameter is ignored if $serializer is false.
     * @return void
     */
    public function setHasCache($key, $value, $dependency = null, $cacheExpiration = null)
    {
        if ($this->isCachable()) {
            
            if (is_array($dependency)) {
                $dependency = Yii::createObject($dependency);
            }
            
            Yii::$app->cache->set($key, $value, (is_null($cacheExpiration)) ? $this->cacheExpiration : $cacheExpiration, $dependency);
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
            
            $enumKey = (is_array($key)) ? implode(",", $key) : $key;
            
            if ($data) {
                Yii::info("Cacheable trait key '$enumKey' successfully loaded from cache.", __METHOD__);
                return $data;
            }
            Yii::info("Cacheable trait key '$enumKey' has not been found in cache.", __METHOD__);
        }
    
        return false;
    }
}
