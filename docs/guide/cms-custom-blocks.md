Create a new block inside your project
=====================================

Put all your project specific cms blocks inside a ***blocks*** folder. This blocks folder is placed in the projects root folder.

An example code of a block could look like this: (The file Test is placed in ***blocks/Test.php***

```
<?php
namespace app\blocks;

class Test extends \cmsadmin\base\Block
{
    public function jsonFromArray()
    {
        return [
            'vars' => [
                ['var' => 'heading', 'label' => 'Uebeschrift 1', 'type' => 'zaa-input-text']
            ]
        ];
    }
    
    public function getTwigFrontend()
    {
        return '<h1>{{ vars.heading }}</h1>';
    }
    
    public function getTwigAdmin()
    {
        return '<h1>{{ vars.heading }}</h1>';
    }
    
    public function getName()
    {
        return 'Überschrift 1';
    }
}
```

To see all configuration possibilitys checkout the [Cms Block Guide](cms-blocks.md).

***render files***

you can also render files instead of simple return strings, like this:

```

public function getTwigFrontend()
{
	return $this->render('my_block_template.twig');
}

```

Now you have to register the block to your database. Go into the administration area, navigation to Cms Settings -> Blocks and add a new item. The field ***class*** you have to provied would look like this, based on the above example:

***\app\blocks\Test***

