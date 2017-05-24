<?php

namespace luya\web\filters;

use yii\base\ActionFilter;
use yii\base\InvalidCallException;
use yii\helpers\VarDumper;

/**
 * Prevent Robots from sending Forms.
 * 
 * This is a very basic spam protection method. If someone sends the form faster then in the
 * given {{luya\web\filters\RobotsFilter::delay}} time, an InvalidCallException will be thrown.
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
    public $delay = 2.5;
    
    const ROBOTS_FILTER_SESSION_IDENTIFIER = '__robotsFilterRenderTime';
    
    private function getRenderTime()
    {
        return Yii::$app->session->get(self::ROBOTS_FILTER_SESSION_IDENTIFIER, 0);
    }
    
    private function setRenderTime($time)
    {
        Yii::$app->session->set(self::ROBOTS_FILTER_SESSION_IDENTIFIER, $time);
    }
    
    public function beforeAction($action)
    {
        if (Yii::$app->request->isPost) {
            if ((time() - $this->getRenderTime()) < $this->delay) {
                throw new InvalidCallException("Robots Filter has detected an invalid Request: " . VarDumper::export(Yii::$app->request->post()));
            }
        }
    }
    
    public function afterAction($action, $result)
    {
        $this->setRenderTime(time());
        
        return $result;
    }
}