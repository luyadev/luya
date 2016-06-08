<?php

namespace luya\web\filters;

use Yii;
use yii\base\ActionFilter;
use luya\traits\CacheableTrait;
use yii\web\Response;

/**
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
    
    public $actions = [];
    
    /**
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
    
    public function cacheResponseContent($event)
    {
        $this->setHasCache($this->calculateCacheKey(), $event->sender->content, $this->dependency, $this->duration);
    }
    
    /**
     * 
     * @return array
     */
    protected function calculateCacheKey()
    {
        $key = [__CLASS__];
        $key[] = Yii::$app->requestedRoute;
        if (is_array($this->variations)) {
            foreach ($this->variations as $value) {
                $key[] = $value;
            }
        }
        return $key;
    }
}