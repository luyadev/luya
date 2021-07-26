## JSON-LD

Modern web applications needs to provide the websites informations in structure way for search engines, therefore you can use {{luya\web\JsonLd}}. The inheritation and full documentation about the schema itself is available under http://schema.org.

## Basic usage

Every JSON-LD property starts within a given type like `Person` the base of every type is `Thing`. The following list highlights the most common used types:

|Name|Usage
|----|-----
|{{luya\web\jsonld\Thing}}|This is the base object for every JSON-LD object.
|{{luya\web\jsonld\Person}}|Authors for serveral things like blog post, comments or used when having text about a person.
|{{luya\web\jsonld\BlogPosting}}|Used for Blog posts or news articles.
|{{luya\web\jsonld\Organization}}|Provides information about an organization such as a school, NGO, corporation, club, etc.
|{{luya\web\jsonld\CreativeWork}}|Providing informations about a given work.
|{{luya\web\jsonld\Place}}|Describes location, for example to provide the company location.
|{{luya\web\jsonld\ImageObject}}|Used for images or galleries.
|{{luya\web\jsonld\Comment}}|Could be used for user comments.
|{{luya\web\jsonld\ContactPoint}}|E-Mail, Telephone or address.
|{{luya\web\jsonld\Offer}}|Providing an estore offer.


```php
JsonLd::person()
   ->setGivenName('Albert')
   ->setFamilyName('Einstein')
   ->setBirthPlace('Ulm, Germany');
```

Keep in mind that a lot of objects require a certain sub object. This makes it more complex to build and understand, but also provides the possibility for the nesting which are required by the schema defintions. For example the `BlogPosting` publisher requires an `Organisation` object and the organisation logo requires an `ImageObject` object:

```php
$logo = (new ImageObject())
    ->setUrl(new UrlValue('https://example.com/johndoe.jpg'));

$organisation = (new Organization())
    ->setName('John Doe')
    ->setLogo($logo);
        
JsonLd::blogPosting()
    ->setPublisher($organisation)
```

Currently we do not have all possible types implemented but you can always register them by yourself by calling {{luya\web\JsonLd::addGraph()}} with an array which contains the defintions:

```php
luya\web\JsonLd::addGraph([
    "url" => "https://heartbeat.gmbh/blog/2018/5-jahre-heartbeat-aarau",
    "@type" => "BlogPosting",
|);
```

## Value Types

Some properties require a given type of value, therefore we have Value objects. Some methods can require those objects in order to make sure the correct value is passed to the properties, otherwise you could enter values which are not valid for the given key. 

An example for a value object with an URL to a given image:

```php
$image = (new ImageObject())
    ->setUrl(new UrlValue('https://example.com/johndoe.jpg'));
```

The value object will then parse the input correctly for the given schema property.

|Name|Usage|
|----|-----|
|{{luya\web\jsonld\DateTimeValue}}|Used for timestamps with time.
|{{luya\web\jsonld\DateValue}}|Used for date values.
|{{luya\web\jsonld\DurationValue}}|Time periods as duration.
|{{luya\web\jsonld\UrlValue}}|Used for paths to images or websites (links).
|{{luya\web\jsonld\TextValue}}|Used when objects needs to get shorten or encode the text values is required.

## Advanced usage

An example for providing structured JSON-LD for a blog with LUYA CMS module:

```php
$current = Yii::$app->menu->current;

// register general thing information about the current page
JsonLd::thing()
    ->setName($current->title)
    ->setDescription($current->description)
    ->setUrl(new UrlValue($current->absoluteLink))
    
// author
$author = (new Person())
    ->setName($current->userCreated->firstname . " " . $current->userCreated->lastname);
    
// about
$about = (new Thing())
    ->setDescription($current->title);
    
// company logo definition
$companyLogo = (new ImageObject())
    ->setUrl(new UrlValue('https://example.com/company-logo.jpg'));
    
// publisher
$publisher = (new Organization())
    ->setName('My company')
    ->setLogo($companyLogo);
    
// register the blog post
JsonLd::blogPosting()
    ->setAbout($about)
    ->setAuthor($author)
    ->setPublisher($publisher)
    ->setDateCreated(new DateTimeValue($current->dateCreated))
    ->setDateModified(new DateTimeValue($current->dateUpdated))
    ->setDatePublished(new DateTimeValue($current->dateCreated))
    ->setHeadline(new TextValue($current->description))
    ->setUrl(new UrlValue($current->absoluteLink));
```
