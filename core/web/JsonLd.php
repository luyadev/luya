<?php

namespace luya\web;

use luya\web\jsonld\Organization;
use luya\web\jsonld\Thing;
use Yii;
use yii\base\Object;
use yii\helpers\Json;
use luya\helpers\Url;
use luya\helpers\ArrayHelper;
use luya\web\jsonld\Person;
use luya\Exception;
use luya\web\jsonld\BaseThing;
use luya\web\jsonld\Event;

/**
 * Registerin Microdata as JsonLD.
 *
 * In order to register a json ld tag just call:
 *
 * ```php
 * JsonLd::sponsor('Jon Doe', 'https://luya.io');
 * ```
 *
 * Or any other tags. This will register the json ld output into the layout file of the view.
 *
 * @see https://schema.org/docs/schemas.html
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class JsonLd extends Object
{
    /**
     * Register new Thing.
     *
     * @param array $config Optional config array to provided person data via setter methods.
     *
     * @return \luya\web\jsonld\Thing
     */
    public static function thing(array $config = [])
    {
        return self::addGraph((new Thing($config)));
    }

    /**
     * Register new Organization.
     *
     * @param array $config Optional config array to provided person data via setter methods.
     *
     * @return \luya\web\jsonld\Organization
     */
    public static function organization(array $config = [])
    {
        return self::addGraph((new Organization($config)));
    }
    
    /**
     * Register new Event.
     *
     * @param array $config
     *
     * @return \luya\web\jsonld\Event
     */
    public static function event(array $config = [])
    {
        return self::addGraph((new Event($config)));
    }
    
    /**
     * Register new Person.
     *
     * @param array $config Optional config array to provided person data via setter methods.
     *
     * @return \luya\web\jsonld\Person
     */
    public static function person(array $config = [])
    {
        return self::addGraph((new Person($config)));
    }
    
    /**
     * Register Image Microodata.
     *
     * @param string $url
     * @param string $caption The image caption about what is on the picture.
     * @param array $options An array with optional informations, allowed:
     * - contentLocation: The location where the image was taken.
     * - author: The author who made the picture.
     * - datePublished: A unix timestamp (or string e.g. 2008-01-25) when the image was published.
     * - name: The name of the picture.
     */
    public static function image($url, $caption, array $options = [])
    {
        $date = ArrayHelper::remove($options, 'datePublished', null);
        
        if ($date !== null && is_numeric($date)) {
            $date = date("Y-d-m", $date);
        }
        
        self::addGraph([
            "@context" => "http://schema.org",
            "@type" => "ImageObject",
            "author" => ArrayHelper::remove($options, 'author', null),
            "contentLocation" => ArrayHelper::remove($options, 'contentLocation', null),
            "contentUrl" => $url,
            "datePublished" => $date,
            "description" => $caption,
            "name" => ArrayHelper::remove($options, 'name', null),
        ]);
    }
    
    /**
     * Register graph data.
     *
     * @param \luya\web\jsonld\BaseThing|array $data Can be either an array or an object based on {{luya\web\jsonld\BaseThing}} which contains the Arrayable Inteface.
     * @return
     */
    public static function addGraph($data)
    {
        self::registerView();
        
        if (is_scalar($data)) {
            throw new Exception("data must be either an array or an object of type luya\web\jsonld\BaseThing.");
        }
        
        Yii::$app->view->params['@graph'][] = $data;
        
        return $data;
    }
    
    /**
     * Reset the JsonLd Data.
     *
     * This method is mainly usefull when working with unit tests for JsonLd.
     */
    public static function reset()
    {
        self::$_view = null;
        Yii::$app->view->params['@graph'] = [];
    }
    
    private static $_view;
    
    /**
     * Register the view file an observe the event which then reads the data from @graph params key.
     */
    protected static function registerView()
    {
        if (self::$_view === null) {
            Yii::$app->view->on(View::EVENT_BEGIN_BODY, function ($event) {
                echo '<script type="application/ld+json">' . Json::encode($event->sender->params) . '</script>';
            });
                    
            self::$_view = true;
        }
    }
}
