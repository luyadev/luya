# CMS Blocks

Blocks are elements used in the CMS Module to display and configure data. Blocks are dropped into the placeholders of a [CMS Layout](app-cmslayouts.md). An example of a Block could be a paragraph tag where the user can add the content. LUYA CMS Module is shipped with some default Blocks, but you can create your own elements.

## Create a new Block

> use `./vendor/bin/luya cms/block/create` console command to generate a Block.

You can add Blocks to your application or to a module. In either case, the folder where the blocks are stored must be named as **blocks**. Additionaly blocks should have the suffix `Block`. 

For example, we create a Block `TextTransformBlock` and store it in `app/blocks` or `app/modules/yourmodule/blocks`.

This is what the `TextTransformBlock` could looke like in your code:

```php
<?php
namespace app\blocks;

class TextTransformBlock extends \luya\cms\base\PhpBlock
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

    public function admin()
    {
        return 'Administrations View: {{ vars.mytext }}';
    }
}
```

As we have switched to PHPBlock by default (in beta8) you now have to create also a view file, which is located in the view folder of your application: `app/views/blocks/`. The view itself must have the same name as the class name of your block: `TextTransformBlock.php`. 

In the example above, the view file should looke like this:

```php
<?php
/* @var $this \luya\cms\base\PhpBlockView */
?>

<?php if ($this->varValue('mytext')): ?>
    <h1><?= $this->extraValue('textTransformed'); ?></h1>
<?php endif; ?>
```

In order to retrieve values from configurations (`$this->[METHOD]`):

|Type|Method
|----|------
|var|{{luya\cms\base\PhpBlockView::varValue}}
|cfg|{{luya\cms\base\PhpBlockView::cfgValue}}
|extra|{{luya\cms\base\PhpBlockView::extraValue}}
|placeholder|{{luya\cms\base\PhpBlockView::placeholderValue}}

Check the {{\luya\cms\base\PhpBlockView}} for full method reference to use inside the php block view.

#### Register and import

After creating a Block, you have to *Import* it into your application. The reason behind the import process is to avoid rely on database structure and to work with php files you can also check into version controller system. Run the [Import Command](luya-console.md):

```sh
./vendor/bin/luya import
```

This will add or update the Block into the CMS system. If you rename or remove a Block from your application, the old block will be deleted from your database.

#### Methods in detail

|Name|Return|Description
|----|--------|------------
|icon|string|Return the [Materialize-Icon](https://design.google.com/icons/) name
|name|string|Return the Humand Readable name for the administration area.
|config|array|Define all config variables there user can input in the administration area `cfgs`, `vars` and `placeholders`. Read more about [CMS Block Config and different input types](app-block-types.md).
|extraVars|array|Define additional variables to your template, so you can reuse them inside your view with `$extras.VAR_NAME`.
|admin|string|Returns the [Twig.js](https://github.com/justjohn/twig.js/wiki) template to be display in the administration area.

### Module blocks

When you add a Block inside of a module you have to define the `$module` properties, this is will make sure the view file are found in the correct folder. This way, you can redistributed Blocks with your own package to other users.

```php
class TestBlock extends \luya\cms\base\PhpBlock
{
    public $module = 'mymodule';
}
```

#### Override default blocks

> Overriding blocks is removed from the guide, as its encountert as a misfit practice.

## Caching

To speed up your system you can enable the cache for each block, to enable the caching you have to define a [caching component](http://www.yiiframework.com/doc-2.0/guide-caching-data.html#cache-components) in your config. By default block caching is disabled for all blocks.

```php
class MyTestBlock extends \luya\cms\base\PhpBlock
{
    public $cacheEnabled = true;
}
```

This will cache the block for 60 minutes but you can adjust the number of seconds the block should be cached by defining the cacheExpiration propertie:

```php
public $cacheExpiration = 60;
```

You can enable block caching for a block event if the caching component is not registered, so you can redistribute blocks and the behavior of them.

## Env option

Each block is placed in an Environemnt (Env) you can access those informations inside your block logic:

```php
$this->getEnvOption($key, $defaultValue);
```

the following keys are available:

+ **id**: Return the unique identifier from the cms context
+ **blockId**: Returns the id of this block (unique identifier)
+ **context**: Returns frontend or backend to find out in which context you are.
+ **pageObject**: Returns the {{\luya\cms\models\NavItem}} Object where you can run \luya\cms\models\NavItem::getNav}} to retrievew the Nav Object.
+ **isFirst**: Returns whether this block is the first in its placeholder or not.
+ **isLast**: Return whether his block is the last in its placeholder or not.
+ **index**: Returns the number of the index/position within this placheholder.
+ **itemsCount**: Returns the number of items inside this placeholder.
+ **isPrevEqual**: Returns whether the previous item is of the same origin (block type, like text block) as the current.
+ **isNextEqual**: Returns whether the next item is of the same origin (block type, like text block) as the current.
+ **equalIndex**: Get the current index/position of this element within the list of *same* elements.

The properties can help you in order to make a container layout block which auto closes/open the row when working with a grid system like the one from Bootstrap:

```php
<?php if (!$this->isPrevEqual): ?>
<div class="row">
<?php endif; ?>

    <div class="col-md-3">
       <h1>The Block Content.</h1>
    </div>

<?php if (!$this->isNextEqual): ?>
</div>
<?php endif; ?>
```

The above example would only open the row element once and closes the row container when the next element is not an element of the current block.

#### Properties from CMS Page

If there are any CMS properties defined you can access them like this:

```php
$propObject = $this->getEnvOption('pageObject')->nav->getProperty('myCustomProperty');
```

If there is a property defined you will get the property object otherwhise returning `false`.

## Using assets in Blocks

Sometimes your block should also register some css or js files, therfore you can access the global {{\luya\web\View}} Object inside of your PHP view template. Its like registering other assets, by the difference that you are accessing the global scope view instead of the view on `$this`. An example of how to integrate an asset file:

Assuming the below code is the PHP View of your Block:

```php
MyBlockAsset::register($this->appView);
```

Now your [[app-assets.md]] is registered in the appliation view object.

## Register JS or CSS in Block View (inline)

Sometimes your block needs to pass data to JS (or CSS). The easiest way to do that is to register your data in the Blocks View file.

### JS

```php
$this->appView->registerJs("
    var data = ['some', 'data'];
", luya\web\View::POS_READY); 
```

### CSS

```php
$this->appView->registerCss("
    .data { color: red; }
"); 
```

## Ajax Requests in Block

To implement ajax inside a block the following concept is used:

+ {{\luya\cms\base\InternalBaseBlock::createAjaxLink()}}: Create the link to the callback, this url must be used for your ajax requests.
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
$this->createAjaxLink('HellWorld', ['time' => time()]);
```

You could store this created link from above inside your extras vars and pass it to the javascript.

#### Callback parameters

You can pass aditional values to the callback by using the post ajax method and collect them in your callback via Yii::$app->request->post(). The get parameters are used to resolve the callback.


# Block Groups

We have added the ability to manage the block groups via classes, so you can add new groups on your blocks can depend on a block group, when you run the import command luya will create the folders (block groups) and add/update the blocks into the provided groups.

To add new blockgroups create folder in your `@app` namespace, or inside a module with the name `blockgroups`, to add a folder create class like this `app\blockgroups\MySuperGroup`:

```php
<?php
namespace app\blockgroups;

class MySuperGroup extends \luya\cms\base\BlockGroup
{
    public function identifier()
    {
        return 'my-super-group';
    }
    
    public function label()
    {
        return 'My Super Group Elements';
    }
    
    public function getPosition()
    {
        return 30;
    }
}
```

> The position of the block will start from lower to higher, means 1 will be at the top of the groups list in the administration and even higher will be more at the bottom.

the folder will be created on import. Now blocks can belong to this folder, to do so override the {{\luya\cms\base\BlockInterface::blockGroup}} method of your block:

```php
public function blockGroup()
{
    return \app\blockgroups\MySuperGroup::className();
}
```

You can also use one of the predefined group block class:

+ {{\luya\cms\frontend\blockgroups\MainGroup}} (this is default group for all blocks)
+ {{\luya\cms\frontend\blockgroups\LayoutGroup}}
+ {{{luya\cms\frontend\blockgroups\ProjectGroup}}
+ {{\luya\cms\frontend\blockgroups\DevelopmentGroup}}
+ {{\luya\cms\frontend\blockgroups\MediaGroup}}
+ {{\luya\cms\frontend\blockgroups\TextGroup}}

# Variations

In order to provide block flavors configure your `blockVariation` property of the `cmsadmin` module inside your configuration file as follow:

```php
'cmsadmin' => [
    'class' => 'luya\cms\admin\Module',
    'blockVariations' => [
        TextBlock::variations()
            ->add('bold-flavor', 'Bold font with Markdown')->cfgs(['cssClass' => 'bold-font'])->vars(['textType' => 1])
            ->add('italic-flavor', 'Italic Font')->cfgs(['cssClass' => 'italic-font'])
            ->register(),
    ]
],
```
