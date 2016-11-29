# Tags

The LUYA tags are a very strong usefull bb code similiar tag parsing concept. You can just add your own tag within an application or ship them directly with modules. The basic idea behind the tag parser is to enhance the Makrkdown syntax by your customized tags.

Lets assume you want to create a [Bootstrap Tooltip](http://getbootstrap.com/javascript/#tooltips) right at the fingertips of all contents in all modules or views. As the [Elements](concept-elements.md) is thought to be a tool for the developer itself, the tag differs from this idea. It can be easily used by all editors of the administration area.

## Create a Tag

As mentioned above, we create a new TooltipTag with a PHP file somewhere you might think its a good location, we recommend to store them in the `app/tags` folder:

```php
namespace app\tags;

use luya\tag\BaseTag;

class TooltipTag extends BaseTag
{
    public $position = 'left';
    
    public function markdown()
    {
        return 'Provide all informations to the administration interface, as tags are listed under help section and are visible to all administration users.';
    }
    
    public function parse($value, $sub)
    {
        return '<span data-toggle="tooltip" data-placement="'.$this->position.'" title="'.$sub.'">'.$value.'</span><script>$(document).ready(function(){ $(\'[data-toggle="tooltip"]\').tooltip(); });</script>';
    }
}
```

When your Tag is read you have to inject them to the {{luya\TagParser}}. In order to inject the above created Tag add the `$tags` propertie to your application config:

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

Now you have registered the tag under the name **tooltip**. As now you can access the Tag within every CMS or CRUD situation by just call:

```
I am tooltip[John Doe](This showns when hover, over me).
```

## Parse Text

Sometimes you are not in a context where the parsing is enabled, so you can parser your content by using the {{luya\TagParser::convert}} or even directly with markdown integration {{luya\TagParser::convertWithMarkdown}} this enables you to parse tags even in your controllers or views.
