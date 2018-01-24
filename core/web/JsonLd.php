<?php

namespace luya\web;

use Yii;
use yii\helpers\Json;
use yii\base\BaseObject;
use luya\Exception;
use luya\web\jsonld\Person;
use luya\web\jsonld\Event;
use luya\web\jsonld\Place;
use luya\web\jsonld\LiveBlogPosting;
use luya\web\jsonld\Article;
use luya\web\jsonld\BlogPosting;
use luya\web\jsonld\CreativeWork;
use luya\web\jsonld\Organization;
use luya\web\jsonld\SocialMediaPosting;
use luya\web\jsonld\Thing;
use luya\web\jsonld\ImageObject;
use luya\web\jsonld\AggregateRating;
use luya\web\jsonld\Rating;
use luya\web\jsonld\Comment;
use luya\web\jsonld\ContactPoint;
use luya\web\jsonld\Country;
use luya\web\jsonld\Offer;
use luya\web\jsonld\PostalAddress;
use luya\web\jsonld\PropertyValue;

/**
 * Registerin Microdata as JsonLD.
 *
 * In order to register a json ld tag just call:
 *
 * ```php
 * JsonLd::person()
 *    ->setGivenName('Albert')
 *    ->setFamilyName('Einstein')
 *    ->setBirthPlace('Ulm, Germany');
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
     * An article, such as a news article or piece of investigative report.
     * Newspapers and magazines have articles of many different types and this is intended to cover them all.
     *
     * @param array $config Optional config array to provided article data via setter methods.
     * @return \luya\web\jsonld\Article
     * @since 1.0.1
     */
    public static function article(array $config = [])
    {
        return self::addGraph((new Article($config)));
    }

    /**
     * Register new Blog Posting.
     *
     * @param array $config Optional config array to provided blog posting data via setter methods.
     * @return \luya\web\jsonld\BlogPosting
     * @since 1.0.1
     */
    public static function blogPosting(array $config = [])
    {
        return self::addGraph((new BlogPosting($config)));
    }

    /**
     * Register new Thing.
     *
     * @param array $config Optional config array to provided person data via setter methods.
     * @return \luya\web\jsonld\Thing
     */
    public static function thing(array $config = [])
    {
        return self::addGraph((new Thing($config)));
    }

    /**
     * Register new CreativeWork.
     *
     * The most generic kind of creative work, including books, movies, photographs, software programs, etc.
     *
     * @param array $config Optional config array to provided creative work data via setter methods.
     * @return \luya\web\jsonld\CreativeWork
     * @since 1.0.1
     */
    public static function creativeWork(array $config = [])
    {
        return self::addGraph((new CreativeWork($config)));
    }
    
    /**
     * Register new Event.
     *
     * An event happening at a certain time and location, such as a concert, lecture, or festival.
     *
     * @param array $config
     * @return \luya\web\jsonld\Event
     */
    public static function event(array $config = [])
    {
        return self::addGraph((new Event($config)));
    }

    /**
     * Register new Live Blog Posting.
     *
     * A blog post intended to provide a rolling textual coverage of an ongoing event through continuous updates.
     *
     * @param array $config Optional config array to provided live blog posting data via setter methods.
     * @return \luya\web\jsonld\LiveBlogPosting
     * @since 1.0.1
     */
    public static function liveBlogPosting(array $config = [])
    {
        return self::addGraph((new LiveBlogPosting($config)));
    }

    /**
     * Register new Organization.
     *
     * An organization such as a school, NGO, corporation, club, etc.
     *
     * @param array $config Optional config array to provided organization data via setter methods.
     * @return \luya\web\jsonld\Organization
     */
    public static function organization(array $config = [])
    {
        return self::addGraph((new Organization($config)));
    }
    
    /**
     * Register new Person.
     *
     * A person (alive, dead, undead, or fictional).
     *
     * @param array $config Optional config array to provided person data via setter methods.
     * @return \luya\web\jsonld\Person
     */
    public static function person(array $config = [])
    {
        return self::addGraph((new Person($config)));
    }

    /**
     * Register new Place
     *
     * Entities that have a somewhat fixed, physical extension.
     *
     * @param array $config Optional config array to provided place data via setter methods.
     * @return \luya\web\jsonld\Place
     */
    public static function place(array $config = [])
    {
        return self::addGraph((new Place($config)));
    }

    /**
     * Register new Social Media Posting.
     *
     * A post to a social media platform, including blog posts, tweets, Facebook posts, etc.
     *
     * @param array $config Optional config array to provided social media posting data via setter methods.
     * @return \luya\web\jsonld\SocialMediaPosting
     * @since 1.0.1
     */
    public static function socialMediaPosting(array $config = [])
    {
        return self::addGraph((new SocialMediaPosting($config)));
    }

    /**
     * Register new Image Object.
     *
     * @param array $config
     * @return \luya\web\jsonld\ImageObject
     * @since 1.0.3
     */
    public static function imageObject(array $config = [])
    {
        return self::addGraph((new ImageObject($config)));
    }
    
    /**
     * Register new Aggregated Rating.
     *
     * @param array $config
     * @return \luya\web\jsonld\AggregateRating
     * @since 1.0.3
     */
    public static function aggregateRating(array $config = [])
    {
        return self::addGraph((new AggregateRating($config)));
    }

    /**
     * Register new Rating.
     *
     * @param array $config
     * @return \luya\web\jsonld\Rating
     * @since 1.0.3
     */
    public static function rating(array $config = [])
    {
        return self::addGraph((new Rating($config)));
    }
    
    /**
     * Register new Comment.
     *
     * @param array $config
     * @return \luya\web\jsonld\Comment
     * @since 1.0.3
     */
    public static function comment(array $config = [])
    {
        return self::addGraph((new Comment($config)));
    }
    
    /**
     * Register new Contact Point.
     *
     * This is mainly used for addresses or user coordinates like email, telephone etc.
     *
     * @param array $config
     * @return \luya\web\jsonld\ContactPoint
     * @since 1.0.3
     */
    public static function contactPoin(array $config = [])
    {
        return self::addGraph((new ContactPoint($config)));
    }
    
    /**
     * Register new Country.
     *
     * @param array $config
     * @return \luya\web\jsonld\Country
     * @since 1.0.3
     */
    public static function country(array $config = [])
    {
        return self::addGraph((new Country($config)));
    }

    /**
     * Register new Offer.
     *
     * This is used for selling products.
     *
     * @param array $config
     * @return \luya\web\jsonld\Offer
     * @since 1.0.3
     */
    public static function offer(array $config = [])
    {
        return self::addGraph((new Offer($config)));
    }
    
    /**
     * Register new Postal Address.
     *
     * @param array $config
     * @return \luya\web\jsonld\PostalAddress
     * @since 1.0.3
     */
    public static function postalAddress(array $config = [])
    {
        return self::addGraph((new PostalAddress()));
    }
    
    /**
     * Register new Property Value.
     *
     * @param array $config
     * @return \luya\web\jsonld\PropertyValue
     * @since 1.0.3
     */
    public static function propertyValue(array $config = [])
    {
        return self::addGraph((new PropertyValue($config)));
    }
    
    /**
     * Register graph data.
     *
     * @param \luya\web\jsonld\BaseThing|array $data Can be either an array or an object based on {{luya\web\jsonld\BaseThing}} which contains the Arrayable Inteface.
     * @return array|object
     */
    public static function addGraph($data)
    {
        self::registerView();
        
        if (is_scalar($data)) {
            throw new Exception("Data must be either an array or an object of type luya\web\jsonld\BaseThing.");
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
