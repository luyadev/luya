## JsonLd 

Modern web applications needs to provide the websites informations in structure way for search engines, therefore you can use {{luya\web\JsonLd}}. The inheritation and full documentation is available at http://schema.org.

## Basic usage

Every JsonLd property starts within a given group like `person`. The following list highlights just the most common used types:

|Name|Usage
|----|-----
|{{luya\web\jsonld\Thing}}|This is the base object for every json ld object.
|{{luya\web\jsonld\Person}}|Authors for serveral things like blog post, comments or used when having text about a person.
|{{luya\web\jsonld\BlogPosting}}|Used for Blog posts or news articles.
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

Keep in mind that a lot of objects require a certain sub object like, this makes it more complex to build, but it allows all possible chaining as the schema defintion is inheriting different objects. For example can the blogPosting publisher requires and organisation object:

```php
$logo = (new ImageObject())
	->setUrl(new UrlValue('https://example.com/johndoe.jpg'));

$organisation = (new Organization())
	->setName('John Doe')
	->setLogo($logo);
		
JsonLd::blogPosting()
	->setPublisher($organisation)
```

Currently we do not have all possible objects implemented, but you can always register them by yourself by calling {{luya\web\JsonLd::addGraph()}} with an array.

```php
luya\web\JsonLd::addGraph([
	"url" => "https://heartbeat.gmbh/blog/2018/5-jahre-heartbeat-aarau",
	"@type" => "BlogPosting",
|);
```

## Value Types

Some values require a given type of value, therefore we have Value objects. Some methods can require those objects in order to make sure the correct values is provided otherwise you could enter values which are not valid for the given key. 

An example for a value object with an url to a given image:

```php
$image = (new ImageObject())
	->setUrl(new UrlValue('https://example.com/johndoe.jpg'));
```

The value object will then parse the input correctly for the given object key.

|Name|Usage|
|----|-----|
|{{luya\web\jsonld\DateTimeValue}}|Used for timestamps with time.
|{{luya\web\jsonld\DateValue}}|Used for date values.
|{{luya\web\jsonld\DurationValue}}|Timeperiods as duration. The value will be passed to strtotime.
|{{luya\web\jsonld\UrlValue}}|Used for paths to images or websites.
|{{luya\web\jsonld\TextValue}}|Used when objects needs to shorten or encode the text values.

## Advanced usage

An example for providing json ld for a blog with LUYA cms module:

```php
$current = Yii::$app->menu->current;

JsonLd::thing()
	->setName($current->title)
	->setDescription($current->description)
	->setUrl(new UrlValue($current->absoluteLink))
	->setImage((new ImageObject())->setUrl(new UrlValue($image->sourceAbsolute)));
	
	
JsonLd::blogPosting()
	->setAbout((new Thing())->setDescription($current->title))
	->setAuthor((new Person())->setName($current->userCreated->firstname . " " . $current->userCreated->lastname))
	->setDateCreated(new DateTimeValue($current->dateCreated))
	->setDateModified(new DateTimeValue($current->dateUpdated))
	->setDatePublished(new DateTimeValue($current->dateCreated))
	->setPublisher((new Organization())->setName('John Doe')->setLogo((new ImageObject())->setUrl(new UrlValue('https://example.com/johndoe.jpg'))))
	->setHeadline(new TextValue($current->description))
	->setImage((new ImageObject())->setUrl(new UrlValue($image->sourceAbsolute)))
	->setUrl(new UrlValue($current->absoluteLink));
```