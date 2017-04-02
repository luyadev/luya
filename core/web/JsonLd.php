<?php

namespace luya\web;

use Yii;
use yii\base\Object;
use yii\helpers\Json;
use luya\helpers\Url;
use luya\helpers\ArrayHelper;

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
     * Register Organization.
     *
     * @param unknown $companyName
     * @param unknown $website
     */
    public static function organization($companyName, $website = null)
    {
        self::addGraph([
            '@context' => 'http://schema.org',
            '@type' => 'Organization',
            'name' => $companyName,
            'url' => Url::home(true),
        ]);
    }
    
    /**
     * Register a Person.
     *
     * @param unknown $firstname
     * @param unknown $lastname
     * @param unknown $jobTitle
     */
    public static function person($firstname, $lastname, $jobTitle = null)
    {
        self::addGraph([
            "@context" => "http://schema.org",
            "name" => $firstname . ' ' . $lastname,
            "givenName" => $firstname,
            "familyName" => $lastname,
            "jobTitle" => $jobTitle
        ]);
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
    
    private static $_graphs = [];
    
    /**
     * Register an json array to the view.
     *
     * If an array value is null, it will be filtered and removed.
     *
     * @param array $json The json tag. If values with null available, the element will be removed.
     */
    public static function addGraph(array $json)
    {
        self::registerView();
        
        foreach ($json as $key => $value) {
            if ($value === null) {
                unset($json[$key]);
            }
        }
        Yii::$app->view->params['@graph'][] = $json;
    }
    
    private static $_view = null;
    
    private static function registerView()
    {
        if (self::$_view === null) {
            Yii::$app->view->on(View::EVENT_BEGIN_BODY, function ($event) {
                echo '<script type="application/ld+json">' . Json::encode($event->sender->params) . '</script>';
            });
                    
            self::$_view = true;
        }
    }
}
