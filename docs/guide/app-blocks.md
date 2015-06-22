Create a new block inside your project
=====================================

Put all your project specific cms blocks inside a ***blocks*** folder. This blocks folder is placed in the projects root folder.

An example code of a block could look like this: (The file Test is placed in ***blocks/Test.php***

```php
<?php
namespace cmsadmin\blocks;

class ImageBlock extends \cmsadmin\base\Block
{
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'imageId', 'label' => 'Bild', 'type' => 'zaa-image-upload'],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'image' => \yii::$app->luya->storage->image->get($this->getVarValue('imageId'))
        ];
    }
    
    public function twigFrontend()
    {
        return '<img src="{{extras.image.source}}" border="0" /> {{dump(extras)}}';
    }

    public function twigAdmin()
    {
        return '<p>{% if extras.image.source %}<img src="{{extras.image.source}}" border="0" height="100" />{% else %}<strong>Es wurde noch kein Bild Hochgeladen.</strong>{% endif %}</p>';
    }

    public function name()
    {
        return 'Bild';
    }
}

```

To see all configuration possibilitys checkout the [Cms Block Guide](cms-blocks.md).

***render files***

you can also render files instead of simple return strings, like this:

```php

public function twigFrontend()
{
	return $this->render();
}

```

by default it will look for a view file inside @app/views/blocks. By changing the module property inside the class object you can changed the path in where the file should be found:

```php

public $module = 'mymodule';

```
or
```php

public function getModule()
{
	return '@mymodule';
}
```


Register Block
--------------

Now you have to register the block to your database. Go into the administration area, navigation to Cms Settings -> Blocks and add a new item. The field ***class*** you have to provied would look like this, based on the above example:

***\app\blocks\Test***


Extra Variables
---------------

If you want to access your own defined php variables in twig, you can use the function ```extraVars()```.

### Example:

You want to access the actual time and get the upper case version of your defined text content. However we could do this with native twig, but we'll define it via php vars and functions for the sake of an example.

```
public function extraVars()
    {

       return [
            "mytime" => time(),
            "newtext" => strtoupper($this->getVarValue("text")),
        ];
    }
```

Use the defined extraVars in Twig like this:

```
{{extras.mytime}} {{extras.newtext}}
```

