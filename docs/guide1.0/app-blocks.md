CMS Blocks
==============

> use `./vendor/bin/luya block/create` to build blocks with a cli wizzard.

What are Blocks? Blocks are elements used in the CMS Module to display and configure data. Blocks are dropped into the placeholders of an [cmslayout](app-cmslayouts.md). An easy example of a block could be a pargraph tag where the user can add the content. LUYA CMS Modules ships with some default blocks, but you can always create your own elements.

Create Block
--------------

You can add blocks to your project application or you can also add them to a module, in any case the folder name where the blocks are stored must named as **blocks**. Additionaly blocks should have the suffix `Block`. For example we build a block `TextTransformBlock` and store it in `app/blocks` or `app/modules/yourmodule/blocks`.

### Example

An example text-block who uppercases all letters on output:

```php
<?php
namespace app\blocks;

class TextTransformBlock extends \cmsadmin\base\Block
{
    public function icon()
    {
        return 'extension'; // https://design.google.com/icons/
    }
    
    public function name()
    {
        return 'Transformed Text';
    }
    
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'mytext', 'label' => 'The Text', 'type' => 'zaa-text'],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'textTransformed' => strtoupper($this->getVarValue('mytext')),
        ];
    }
    
    public function twigFrontend()
    {
        return '<p>Original Input: {{vars.mytext}}</p><p>Input in Uppercase: {{extras.textTransformed}}';
    }

    public function twigAdmin()
    {
        return 'Administrations View: {{ vars.mytext }}';
    }
}
```

> Instead of concat the string in `twigFrontend()` you can also use `$this->render()`, this will try to find the view file for this block inside the views folder, named based on a naming convention.

### Register the block

After storing the Block in your project you have to *Import* block into your system. Open the Terminal and run the command:

```sh
./vendor/bin/luya import
```

This will add or update the block into the cms system. If you renamed the block, the old block will be deleted.

### Module blocks

When you add a block inside of a module you have to define the `$module` properties, this is will make sure the view files are found in the correct folder. This way you can redistributed blocks with your own package for other users.

```php
class TestBlock extends \cmsadmin\base\Block
{
    public $module = 'mymodule';
}
```

#### Override default blocks

Sometimes you just want to change the default behavior/template of systems blocks, you can always override all blocks provided from the system by adding a twig template with the name of the block in your project application views folder. Assuming you want to override the **template** of the `TextBlock` which is provided by default from the LUYA cms core. To do so go into your application view folder `views/blocks` and add a twig template with the name of the block, in this case `TextBlock.twig` now the system will pick and render this template first. In addition to this method you could also make a custom block and extend from the existing Text block. `class MyTextBlock extends \cmsadmin\blocks\TextBlock` and override the `twigFrontend()` method so you have your own output.

### Methods explained

|Name |Return |Description
| ---- | --------| ------------
|icon |string |Return the [Materialize-Icon](https://design.google.com/icons/) name
|name |string |Return the Humand Readable name for the administration area.
|config |array |Define all config variables there user can input in the administration area `cfgs`, `vars` and `placeholders`. Read more about [CMS Block Config and different input types](app-block-types.md).
|extraVars |array |Define additional variables to your template, so you can reuse them inside your view with `extras.VAR_NAME`.
|twigFrontend |string |Returns the [Twig](http://twig.sensiolabs.org/) template to display in the frontend.
|twigAdmin |string |Returns the [Twig.js](https://github.com/justjohn/twig.js/wiki) template to be display in the administration area.

Caching
-------

To speed up your system you can enable the cache for each block, to enable the caching you have to define a [caching component](http://www.yiiframework.com/doc-2.0/guide-caching-data.html#cache-components) in your config. By default block caching is disabled for all blocks.

```php
class MyTestBlock extends \cmsadmin\base\Block
{
    public $cacheEnabled = true;
}
```

This will cache the block for 60 minutes but you can adjust the number of seconds the block should be cached by defining the cacheExpiration propertie:

```php
public $cacheExpiration = 60;
```

You can enable block caching for a block event if the caching component is not registered, so you can redistribute blocks and the behavior of them.

Env option
------------

Each block is placed in an Environemnt (Env) you can access those informations inside your block logic:

```php
$this->getEnvOption($key, $defaultValue);
```

the following keys are available:

+ *id* Return the unique identifier from the cms context
+ *blockId* Returns the id of this block (unique identifier)
+ *context* Returns frontend or backend to find out in which context you are.
+ *pageObject* Returns the `cmsadmin\models\NavItem` Object where you can run `getNav()` to retrievew the Nav Object.
+ 
### Property

If there are any CMS properties defined you can access them like this:

```php
$propObject = $this->getEnvOption('pageObject')->nav->getProperty('myCustomProperty');
```

If there is a property defined you will get the property object otherwhise returning `false`.

Register assets
----------------

Blocks can have [Assets (CSS&JS)](app-assets.md). To register an asset use `public $assets = []` and define all assets you want to auto register. Assets will only regsitered in frontend context and are **not available** in the administration area.

```php
class TestBlock extends \cmsadmin\base\Block
{
    public $assets = [
        'apps\assets\TestBlockAsset',
        'apps\assets\TestBlockZweitesAsset',
    ];
}
```

Ajax in blocks
---------------

To implement ajax inside a block the following concept is used:

+ `createAjaxLink()`: Create the link to the callback, this url must be used for your ajax requests.
+ `callback...()`: Define a callbacked, you have to prefix the method with *callback*.

Create a callback and define all parameters. The callback is what the url returns to your javascript, can be html or json.

```php
public function callbackHelloWorld($time)
{
    return 'hallo world ' . $time;
}
```

The above callback requires the parameter `$time` and must be called trough an ajax call inside of the javascript, to create the url for this specific callback we are going to use createAjaxLink:

```php
$this->createAjaxLink('HellWorld', ['zeit' => time()]);
```

You could store this created link from above inside your extras vars and pass it to the javascript.

### Callback parameters

You can pass aditional values to the callback by using the post ajax method and collect them in your callback via Yii::$app->request->post(). The get parameters are used to resolve the callback.


Block Groups
============

> since 1.0.0-beta6

We have added the ability to manage the block groups via classes, so you can add new groups on your blocks can depend on a block group, when you run the import command luya will create the folders (block groups) and add/update the blocks into the provided groups.

To add new blockgroups create folder in your `@app` namespace, or inside a module with the name `blockgroups`, to add a folder create class like this `app\blockgroups\MySuperGroup`:

```
<?php

namespace app\blockgroups;

class MySuperGroup extends \cmsadmin\base\BlockGroup
{
    public function identifier()
    {
        return 'my-super-group';
    }
    
    public function label()
    {
        return 'My Super Group Elements';
    }
}
```

the folder will be created on import. Now blocks can belong to this folder, to do so override the `getBlockGroup` method of your block:

```
public function getBlockGroup()
{
    return \app\blockgroups\MySuperGroup::className();
}
```

You can also use one of the predefined group block class:

+ `\cmsadmin\blockgroups\MainGroup::className()` (this is default group for all blocks)
+ `\cmsadmin\blockgroups\LayoutGroup::className()`
+ `\cmsadmin\blockgroups\ProjectGroup::className()`
+ `\cmsadmin\blockgroups\DevelopmentGroup::className()`
