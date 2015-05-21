Twig functions
==============

the following twig functions are available in all twig ***frontend*** templates. Not in in block twigAdmin, cause they are rendere with twig.js:


links
-----
wrapper functions for the luya links collection findByArguments function. Will return an array of links for the defined method arguments:
```
	{% for item in links('cat', 'lang', 'parent_nav_id') %}
		{{ dump(item) }}
	{% endfor %}
```

linksFindParent
---------------
find the parent navigation id for the current active navigation link for a specific level:
```
	parent level 1 for active link: {{ linksFindParent(1) }}
	parent level 2 for active link: {{ linksFindParent(2) }}
	parent level 3 for active link: {{ linksFindParent(3) }}
```

asset
-----
Get the bundle object from an asset class
```
	<p>{{ asset('my\project\Asset') }}</p>
```
(error cause of object to string conversion, use dump() twig function to look inside the object.

filterApply
-----------
Get the image source (absolut image path) based on imageId and filterIdentifier
```
	<img src="{{ filterApply(my_image_id_from_item, 'my_custom_filter') }}" />
```

image
------
Get an image object from an existing imageId:
```
	<img src="{{ image(my_image_id_from_item).source }}" />
```