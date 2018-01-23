<?php
namespace luyatests\core\web;

use luya\web\jsonld\Article;
use luya\web\jsonld\BlogPosting;
use luya\web\jsonld\CreativeWork;
use luya\web\jsonld\LiveBlogPosting;
use luya\web\jsonld\Organization;
use luya\web\jsonld\SocialMediaPosting;
use luya\web\jsonld\Thing;
use luya\web\JsonLd;
use luya\web\jsonld\Person;
use luya\web\jsonld\ImageObject;
use luya\web\jsonld\DateValue;
use yii\helpers\Json;
use luya\web\jsonld\UrlValue;
use luya\web\jsonld\DateTimeValue;
use luya\web\jsonld\AggregateRating;
use luya\web\jsonld\Comment;
use luya\web\jsonld\ContactPoint;
use luya\web\jsonld\Country;
use luya\web\jsonld\MediaObject;
use luya\web\jsonld\Offer;
use luya\web\jsonld\PostalAddress;
use luya\web\jsonld\Rating;

class JsonLdTest extends \luyatests\LuyaConsoleTestCase
{
    public function testAssignView()
    {
        Jsonld::addGraph(['foo' => 'bar']);
        // this test should only be run once, this its testing the script to view ld part.
        ob_start();
        $this->app->view->beginBody();
        $out = ob_get_contents();
        ob_end_clean();

        $this->assertContains('<script type="application/ld+json">{"@context":"https://schema.org","@graph":[{"foo":"bar"}]}</script>', $out);
        JsonLd::reset();
    }

    public function testBaseThingGetters()
    {
        $thing = (new Thing());
        $same = ['name', 'additionalType', 'alternateName', 'description', 'disambiguatingDescription', 'identifier', 'image', 'mainEntityOfPage', 'sameAs', 'subjectOf', 'url'];
        sort($same);
        $this->assertSame($same, $thing->resolveGetterMethods());
    }

    /**
     * @since 1.0.1
     */
    public function testArticle()
    {
        $thing = (new Article())->setName('The Article');

        $this->assertSame([
            'name' => 'The Article',
            '@type' => 'Article',
        ], $thing->toArray());
    }

    /**
     * @since 1.0.1
     */
    public function testBlogPosting()
    {
        $thing = (new BlogPosting())->setName('The BlogPosting');

        $this->assertSame([
            'name' => 'The BlogPosting',
            '@type' => 'BlogPosting',
        ], $thing->toArray());
        
        $blog = (new BlogPosting())
        ->setSharedContent((new CreativeWork())->setAbout((new Thing())->setDescription("about this")))
        ->setImage(
            (new ImageObject())
            ->setContentUrl(new UrlValue('path/to/image.jpg'))
            ->setUploadDate((new DateValue('12-12-2017')))
            );
        
        $this->assertSame([
            'image' => [
                'contentUrl' => 'path/to/image.jpg',
                'uploadDate' => '12-12-2017',
                '@type' => 'ImageObject',
            ],
            'sharedContent' => [
                'about' => [
                    'description' => 'about this',
                    '@type' => 'Thing',
                ],
                '@type' => 'CreativeWork',
            ],
            '@type' => 'BlogPosting'
        ], $blog->toArray());
    }

    /**
     * @since 1.0.1
     */
    public function testCreativeWork()
    {
        $thing = (new CreativeWork())->setName('The CreativeWork');

        $this->assertSame([
            'name' => 'The CreativeWork',
            '@type' => 'CreativeWork',
        ], $thing->toArray());
    }

    /**
     * @since 1.0.1
     */
    public function testLiveBlogPosting()
    {
        $thing = (new LiveBlogPosting())->setName('The LiveBlogPosting');

        $this->assertSame([
            'name' => 'The LiveBlogPosting',
            '@type' => 'LiveBlogPosting',
        ], $thing->toArray());
    }

    public function testThing()
    {
        $thing = (new Thing())->setName('The Thing');

        $this->assertSame([
            'name' => 'The Thing',
            '@type' => 'Thing',
        ], $thing->toArray());
    }

    public function testOrganization()
    {
        $thing = (new Organization())->setName('The Organization');

        $fields = [
            'name' => 'The Organization',
            '@type' => 'Organization',
        ];

        $this->assertSame($fields, $thing->toArray());
    }

    public function testPerson()
    {
        $thing = (new Person())->setName('The Person');

        $this->assertSame([
            'name' => 'The Person',
            '@type' => 'Person',
        ], $thing->toArray());
    }

    /**
     * @since 1.0.1
     */
    public function testSocialMediaPosting()
    {
        $thing = (new SocialMediaPosting())->setName('The SocialMediaPosting');

        $this->assertSame([
            'name' => 'The SocialMediaPosting',
            '@type' => 'SocialMediaPosting',
        ], $thing->toArray());
    }
    
    public function testImageObject()
    {
        $imageObject = (new ImageObject())->setCaption('foobar');
        
        $this->assertSame([
            'caption' => 'foobar',
            '@type' => 'ImageObject',
        ], $imageObject->toArray());
        
        $imageObject = (new ImageObject())->setCaption('foobar')->setUrl(new UrlValue('image.jpg'));
        
        $this->assertSame([
            'caption' => 'foobar',
            'url' => 'image.jpg',
            '@type' => 'ImageObject',
        ], $imageObject->toArray());
    }
    
    public function testAggregateRating()
    {
        $ar = new AggregateRating();
        $ar->setName('name');
        
        $this->assertSame(['name' => 'name', '@type' => 'AggregateRating'], $ar->toArray());
    }
    
    public function testComment()
    {
        $cmt = new Comment();
        $cmt->setDescription('My comment');
        
        $this->assertSame(['description' => 'My comment', '@type' => 'Comment'], $cmt->toArray());
    }

    public function testContactPoint()
    {
        $cp = new ContactPoint();
        $cp->setEmail('basil@nadar.io');
        
        $this->assertSame(['email' => 'basil@nadar.io', '@type' => 'ContactPoint'], $cp->toArray());
    }
    
    public function testCountry()
    {
        $country = new Country();
        $country->setDescription('Switzerland');
        $this->assertSame(['description' => 'Switzerland', '@type' => 'Country'], $country->toArray());
    }
    
    public function testMediaObject()
    {
        $mo = new MediaObject();
        $mo->setContentUrl(new UrlValue('www.luya.io'));
        
        $this->assertSame(['contentUrl' => 'www.luya.io', '@type' => 'MediaObject'], $mo->toArray());
    }
    
    public function testOffer()
    {
        $offer = new Offer();
        $offer->setDescription('My offer');
        
        $this->assertSame(['description' => 'My offer', '@type' => 'Offer'], $offer->toArray());
    }
    
    public function testPostalAddress()
    {
        $pa = new PostalAddress();
        $pa->setEmail('basil@nadar.io');
        
        $this->assertSame(['email' => 'basil@nadar.io', '@type' => 'PostalAddress'], $pa->toArray());
    }
    
    public function testRating()
    {
        $rating = new Rating();
        $rating->setDescription('my rating');
        
        $this->assertSame(['description' => 'my rating', '@type' => 'Rating'], $rating->toArray());
    }
    
    public function testValuesObjects()
    {
        $this->assertSame('1970-01-02', (new DateValue(123123))->getValue());
        $this->assertSame('1.1.2017', (new DateValue('1.1.2017'))->getValue());
        $this->assertSame('1970-01-02T10:12:03+00:00', (new DateTimeValue(123123))->getValue());
        $this->assertSame('1.1.2017 17:00', (new DateTimeValue('1.1.2017 17:00'))->getValue());
    }
}
