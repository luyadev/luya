<?php

namespace luya\web\filters;

use Yii;
use yii\base\ActionFilter;
use yii\base\InvalidCallException;
use yii\helpers\VarDumper;

/**
 * Prevent Robots from sending Forms.
 *
 * This is a very basic spam protection method. If someone sends the form faster then in the
 * given {{luya\web\filters\RobotsFilter::$delay}} seconds delay time, an InvalidCallException will be thrown.
 *
 * Usage:
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'robotsFilter' => RobotsFilter::class
 *     ];
 * }
 * ```
 *
 * In order to configure the capture delay time use:
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'robotsFilter' => [
 *             'class' => RobotsFilter::class,
 *             'delay' => 0.5,
 *         ]
 *     ];
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RobotsFilter extends ActionFilter
{
	/**
	 * @var float The number of seconds a human would have to fill up the form, before the form is triggered as invalid.
	 */
    public $delay = 2.5;
    
    const ROBOTS_FILTER_SESSION_IDENTIFIER = '__robotsFilterRenderTime';
    
    /**
     * @return integer Returns the latest render timestamp.
     */
    protected function getRenderTime()
    {
        return Yii::$app->session->get(self::ROBOTS_FILTER_SESSION_IDENTIFIER, time());
    }
    
    /**
     * Render Time Setter.
     * 
     * @param integer $time Set the last action timestamp.
     */
    protected function setRenderTime($time)
    {
        Yii::$app->session->set(self::ROBOTS_FILTER_SESSION_IDENTIFIER, $time);
    }
    
    /**
     * Return the elapsed process time to fill in the form.
     * 
     * @return number The elapsed time in seconds.
     */
    protected function getElapsedProcessTime()
    {
        return (int) (time() - $this->getRenderTime());
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (Yii::$app->request->isPost) {
            if ($this->getElapsedProcessTime() < $this->delay) {
                throw new InvalidCallException("Robots Filter has detected an invalid Request: " . VarDumper::export(Yii::$app->request->post()));
            }
        }
        
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        $this->setRenderTime(time());
        
        return $result;
    }
}
