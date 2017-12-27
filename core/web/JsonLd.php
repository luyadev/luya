<?php

namespace luya\web;

use luya\web\jsonld\Article;
use luya\web\jsonld\BlogPosting;
use luya\web\jsonld\CreativeWork;
use luya\web\jsonld\Organization;
use luya\web\jsonld\SocialMediaPosting;
use luya\web\jsonld\Thing;
use Yii;
use yii\helpers\Json;
use luya\web\jsonld\Person;
use luya\Exception;
use luya\web\jsonld\Event;
use luya\web\jsonld\Place;
use yii\base\BaseObject;
use luya\web\jsonld\LiveBlogPosting;

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
class JsonLd extends BaseObject
{

    /**
     * Register new Article.
     *
     * @param array $config Optional config array to provided article data via setter methods.
     * @since 1.0.1
     *
     * @return \luya\web\jsonld\Article
     *
     */
    public static function article(array $config = [])
    {
        return self::addGraph((new Article($config)));
    }

    /**
     * Register new Blog Posting.
     *
     * @param array $config Optional config array to provided blog posting data via setter methods.
     * @since 1.0.1
     *
     * @return \luya\web\jsonld\BlogPosting
     */
    public static function blogPosting(array $config = [])
    {
        return self::addGraph((new BlogPosting($config)));
    }

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
     * Register new CreativeWork.
     *
     * @param array $config Optional config array to provided creative work data via setter methods.
     * @since 1.0.1
     *
     * @return \luya\web\jsonld\CreativeWork
     */
    public static function creativeWork(array $config = [])
    {
        return self::addGraph((new CreativeWork($config)));
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
     * Register new Live Blog Posting.
     *
     * @param array $config Optional config array to provided live blog posting data via setter methods.
     * @since 1.0.1
     *
     * @return \luya\web\jsonld\LiveBlogPosting
     */
    public static function liveBlogPosting(array $config = [])
    {
        return self::addGraph((new LiveBlogPosting($config)));
    }

    /**
     * Register new Organization.
     *
     * @param array $config Optional config array to provided organization data via setter methods.
     *
     * @return \luya\web\jsonld\Organization
     */
    public static function organization(array $config = [])
    {
        return self::addGraph((new Organization($config)));
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
     * Register new Place
     *
     * @param array $config Optional config array to provided place data via setter methods.
     *
     * @return \luya\web\jsonld\Place
     */
    public static function place(array $config = [])
    {
        return self::addGraph((new Place($config)));
    }

    /**
     * Register new Social Media Posting.
     *
     * @param array $config Optional config array to provided social media posting data via setter methods.
     * @since 1.0.1
     *
     * @return \luya\web\jsonld\SocialMediaPosting
     */
    public static function socialMediaPosting(array $config = [])
    {
        return self::addGraph((new SocialMediaPosting($config)));
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
    /*
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
    */
    
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
        
        Yii::$app->view->params['@context'] = 'https://schema.org';
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
