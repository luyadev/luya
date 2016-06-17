<?php

namespace luya\web\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\Response;
use luya\traits\CacheableTrait;

/**
 * Filter to enable Response Cache.
 * 
 * This filter can be applied on actions of a controller and is mainly used to cache API Response Data. The ability
 * to set duration an dependency are limited to a singel filter ability. So in order to use different dependencies 
 * for different actions you have to the response cache as multiple behaviors.
 * 
 * Cache different actions for a duration of 60 minutes:
 * 
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'responseCache' => [
 *             'class' => ResponseCache::className(),
 *             'actions' => [
 *                 'action1', 'action2', 'the-other-action',
 *             ],
 *             'duration' => (60*60)
 *         ]
 *     ];
 * }
 * ```
 * 
 * Cache action with dependency and differnt variations for an action with an `id` param. This allows you to ability
 * to cache only the response for the specific parameter.
 * 
 * ```php
 * public function behvaiors()
 * {
 *     return [
 *         'responseCache' => [
 *              'class' => ResponseCache::className(),
 *              'actions' => [
 *                  'get-data',
 *              ],
 *              'variations' => [
 *                  Yii::$app->request->get('id'),
 *              ],
 *              'dependency' => [
 *                  'class' => 'yii\caching\DbDependency',
 *                  'sql' => 'SELECT * FROM data WHERE id=:id',
 *                  'params' => [':id' => Yii::$app->request->get('id', 0)],
 *              ],
 *         ],
 *     ];
 * }
 * ```
 * 
 * @since 1.0.0-beta7
 * @author Basil Suter <basil@nadar.io>
 */
class ResponseCache extends ActionFilter
{
    use CacheableTrait;
    
    /**
     * @var array list of factors that would cause the variation of the content being cached.
     * Each factor is a string representing a variation (e.g. the language, a GET parameter).
     * The following variation setting will cause the content to be cached in different versions
     * according to the current application language:
     *
     * ```php
     * [
     *     Yii::$app->language,
     * ]
     * ```
     */
    public $variations;
    
    /**
     * @var integer The time of the ResponseCache should be stored, in seconds. When 0 the cache never expires.
     */
    public $duration = 0;
    
    /**
     * @var array|Dependency the dependency that the cached content depends on.
     * This can be either a [[Dependency]] object or a configuration array for creating the dependency object.
     * For example,
     *
     * ```php
     * [
     *     'class' => 'yii\caching\DbDependency',
     *     'sql' => 'SELECT MAX(updated_at) FROM post',
     * ]
     * ```
     *
     * would make the output cache depend on the last modified time of all posts.
     * If any post has its modification time changed, the cached content would be invalidated.
     *
     * If [[cacheCookies]] or [[cacheHeaders]] is enabled, then [[\yii\caching\Dependency::reusable]] should be enabled as well to save performance.
     * This is because the cookies and headers are currently stored separately from the actual page content, causing the dependency to be evaluated twice.
     */
    public $dependency = null;
    
    /**
     * @var array The list of actions where the ResponseCache should be applied. You have to define the actions otherwhise the Response
     * Cache will not be active. For example,
     * 
     * ```php
     * ['get-posts', 'data']
     * ```
     * 
     * actions are defined as ID notation and not in camelcase style, the action prefix is also not used in action defition. For example `actionGetData` would be
     * written as `get-data`.
     */
    public $actions = [];
    
    /**
     * This method will be applied before the action runs in order to determine whether this action should be cached or not.
     * 
     * {@inheritDoc}
     * @see \yii\base\ActionFilter::beforeAction()
     */
    public function beforeAction($action)
    {
        if (!in_array($action->id, $this->actions)) {
            return true;
        }
        
        $cache = $this->getHasCache($this->calculateCacheKey());
        $response = Yii::$app->getResponse();
        
        if ($cache !== false) {
            $response->content = $cache;
            return $response->send();
        }
        
        $response->on(Response::EVENT_AFTER_SEND, [$this, 'cacheResponseContent']);
        
        return true;
    }
    
    /**
     * Will be executed after the Response Object has send its content.
     * 
     * @param \yii\web\ResponseEvent $event
     * @return void
     */
    public function cacheResponseContent($event)
    {
        $this->setHasCache($this->calculateCacheKey(), $event->sender->content, $this->dependency, $this->duration);
    }
    
    private $_cacheKey = null;
    
    /**
     * Calculate the cache key based in several informations in order to make cache key unique.
     * 
     * @return array
     */
    protected function calculateCacheKey()
    {
        if ($this->_cacheKey === null) {
            $key = [__CLASS__, Yii::$app->requestedRoute];
            if (is_array($this->variations)) {
                foreach ($this->variations as $value) {
                    $key[] = $value;
                }
            }
            $this->_cacheKey = $key;   
        }
        
        return $this->_cacheKey;
    }
}