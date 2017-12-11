<?php

namespace luya\traits;

use Yii;

/**
 * Cacheable trait allows caching whether application has caching enabled or not.
 *
 * implementation example:
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
 * $this->setHasCache('myCacheKey', $data, new DbDependency(['sql' => 'SELECT MAX(id) FROM admin_storage_folder WHERE is_deleted=0']), 0);
 * ```
 *
 * You can also use an array notation in order to generate cache dependency:
 *
 * ```php
 * $dependency = [
 *     'class' => 'yii\caching\DbDependency',
 *     'sql' => 'SELECT max(timestamp) FROM table WHERE id=:id',
 *     'params' => [':id' => Yii::$app->request->get('id')],
 * ];
 *
 * $this->setHasCache(['my', 'key'], $data, $dependency);
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
     * @var boolean Whether the caching is enabled or disabled.
     */
    private $_cachable;
    
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
    * Method combines both [[setHasCache()]] and [[getHasCache()]] methods to retrieve value identified by a $key,
    * or to store the result of $closure execution if there is no cache available for the $key.
    *
    * Usage example:
    *
    * ```php
    * use CacheableTrait;
    *
    * public function getTopProducts($count = 10)
    * {
    *     return $this->getOrSetHasCache(['top-n-products', 'n' => $count], function ($cache) use ($count) {
    *         return Products::find()->mostPopular()->limit(10)->all();
    *     }, 1000);
    * }
    * ```
    *
    * @param mixed $key a key identifying the value to be cached. This can be a simple string or
    * a complex data structure consisting of factors representing the key.
    * @param \Closure $closure the closure that will be used to generate a value to be cached.
    * In case $closure returns `false`, the value will not be cached.
    * @param int $duration default duration in seconds before the cache will expire. If not set,
    * [[defaultDuration]] value will be used. 0 means never expire.
    * @param Dependency $dependency dependency of the cached item. If the dependency changes,
    * the corresponding value in the cache will be invalidated when it is fetched via [[get()]].
    * This parameter is ignored if [[serializer]] is `false`.
    * @return mixed result of $closure execution
    */
    public function getOrSetHasCache($key, \Closure $closure, $duration = null, $dependency = null)
    {
        if (($value = $this->getHasCache($key)) !== false) {
            return $value;
        }
        
        $value = call_user_func($closure, $this);
        
        $this->setHasCache($key, $value, $dependency, $duration);
        
        return $value;
    }
    
    /**
     * Store cache data for a specific key if caching is enabled in this application.
     *
     * @param string|array $key The identifier key or a array to store complex keys
     * @param mixed $value The value to store in the cache component.
     * @param \yii\caching\Dependency|array $dependency Dependency of the cached item. If the dependency changes, the corresponding value in the cache will be invalidated when it is fetched
     * via get(). This parameter is ignored if $serializer is false. You can also define an array with defintion which will generate the Object instead of object is provided.
     * @param $cacheExpiration integer The time in seconds before the cache data expires, 0 means never expire.
     * @return boolean Whether set has been success or not
     */
    public function setHasCache($key, $value, $dependency = null, $cacheExpiration = null)
    {
        if ($this->isCachable()) {
            if (is_array($dependency)) {
                $dependency = Yii::createObject($dependency);
            }
            
            return Yii::$app->cache->set($key, $value, (is_null($cacheExpiration)) ? $this->cacheExpiration : $cacheExpiration, $dependency);
        }
        
        return false;
    }
    
    /**
     * Remove a value from the cache if caching is enabled.
     *
     * @param string|array $key The cache identifier
     * @return boolean Whether delete of key has been success or not
     */
    public function deleteHasCache($key)
    {
        if ($this->isCachable()) {
            return Yii::$app->cache->delete($key);
        }
        
        return false;
    }
    
    /**
     * Get the caching data if caching is allowed and there is any data stored for this key.
     *
     * @param string|array $key The identifiere key, can be a string or an array which will be calculated.
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
    
    /**
     * Deletes all values from cache.
     *
     * @return boolean Whether the flush operation was successful.
     */
    public function flushHasCache()
    {
        if ($this->isCachable()) {
            return Yii::$app->cache->flush();
        }
        
        return false;
    }
}
