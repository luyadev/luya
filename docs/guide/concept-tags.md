# Tags

The basic idea behind the tag parser is to enhance the markdown syntax with your customized tags.

LUYA tags are a very strong and useful BBCode (Bulletin Board Code) alike tag parsing concept. You can just add your own tags within an application or ship them directly with modules.

Let's assume you want to create a [Bootstrap tooltip](http://getbootstrap.com/javascript/#tooltips) right at the fingertips of all contents in all modules or views. 
As the [elements](concept-elements.md) is thought to be a tool for the developer itself, the tag differs from this idea. It can be easily used by all editors or users of the admin UI.

## Create a tag

As mentioned above, we create a new `TooltipTag` with a PHP file somewhere where you might think it is a good location, it is recommend locate them in the `app/tags` folder:

```php
namespace app\tags;

use luya\tag\BaseTag;

class TooltipTag extends BaseTag
{
    public $position = 'left';
    
    public function example()
    {
        return 'tooltip[Text](Overlay Tooltip Text)'; 
    }
    
    public function readme()
    {
        return 'Provide all informations to the administration interface, as tags are listed under help section and are visible to all administration users.';
    }
    
    public function parse($value, $sub)
    {
        return '<span data-toggle="tooltip" data-placement="'.$this->position.'" title="'.$sub.'">'.$value.'</span><script>$(document).ready(function(){ $(\'[data-toggle="tooltip"]\').tooltip(); });</script>';
    }
}
```

When your custom tags are ready they need to be injected into the {{luya\TagParser}}. 
In order to inject the created tag from above, add the `$tags` property to your application config (e.g. `configs/env-local.php`):

```php
return [
    'id' => 'myPage',
    // ...
    'tags' => [
        'tooltip' => ['class' => 'app\tags\TooltipTag'],
    ],
    // ...
];
```

After including the example tag in your config file it is available under the name **tooltip**. 
Now you can just use the tag everywhere within CMS or CRUD with the following notation:

```
I am tooltip[John Doe](This tooltip text appears when hovering over John Doe).
```

## Parse a tag

Perhaps you are not in a context where the parsing is enabled. In this case you can parse your content by using {{luya\TagParser::convert()}} or with markdown integration {{luya\TagParser::convertWithMarkdown()}}. This enables the availabilty to parse tags even in your controller or view files.
