<?php
namespace luyatests\core\web;

use luya\web\jsonld\Article;
use luya\web\jsonld\CreativeWork;
use luya\web\jsonld\Organization;
use luya\web\jsonld\SocialMediaPosting;
use luya\web\jsonld\Thing;
use luya\web\JsonLd;
use luya\web\jsonld\Person;

class JsonLdTest extends \luyatests\LuyaWebTestCase
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
        $same = ['name', 'additionalType', 'alternateName', 'description', 'disambiguatingDescription', 'identifier', 'image', 'mainEntityOfPage', 'potentialAction', 'sameAs', 'subjectOf', 'url'];
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
}
