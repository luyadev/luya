# Active Selection

Active Selections are anlog to [[ngrest-activebutton.md]]. When {{luya\admin\ngrest\base\NgRestModel::ngRestActiveSelections()}} are defined, checkboxes will appear in the CRUD list (overview of all records) and a the active selection buttons are visible in the bottom. A click on the button interacts with the selected items/rows.

There are built in Active Selections you can use and configure or you can create your own Active Selections and attach them to an [[ngrest-model.md]].

+ {{luya\admin\selections\DeleteActiveSelection}}

## Inline

Compare to [[ngrest-activebutton.md]] or [[ngrest-activewindow.md]] Active Selections can be defined inline as anonymus function inside the [[ngrest-model.md]] {{luya\admin\ngrest\base\NgRestModel::ngRestActiveSelections()}} method.

#### Basic Usage

As first parameter the callable will recieve an array with all selected models.

```php
public function ngRestActiveSelections()
{
    return [
        [
            'label' => 'Click Me',
            'action' => function(array $items) {
                /** @var \luya\admin\ngrest\base\NgRestModel $item */
                foreach ($items as $item) {
                    // ... do something with the selected item object
                }

                return true;
            }
        ]
    ]
}
```

#### Advanced Response

Its possible to send a reload event, as well as customized success or error messages, therefore a second parameter of the callable is required which takes the {{luya\admin\ngrest\base\ActiveSelection}} context object.

```php
public function ngRestActiveSelections()
{
    return [
        [
            'label' => 'Click Me',
            'action' => function(array $items, \luya\admin\ngrest\base\ActiveSelection $context) {
                /** @var \luya\admin\ngrest\base\NgRestModel $item */
                foreach ($items as $item) {
                    // ... do something with the selected item object
                }

                // sends a reload event, so the ngrest list will be reloaded afterwards. 
                $context->sendReloadEvent();

                return $context->sendSuccess('We did, what you teached.')
            }
        ]
    ]
}
```

## Standalone 

In order to make a configurable and shareable Active Select extends from {{luya\admin\ngrest\base\ActiveSelection}} and override the {{luya\admin\ngrest\base\ActiveSelection::handle()}} method, see {{luya\admin\selections\DeleteActiveSelection}} as example.

```php
class DeleteActiveSelection extends ActiveSelection
{
    /**
{@inheritDoc}
     */
    public $label = 'Delete';

    /**
{@inheritDoc}
     */
    public $icon = 'delete';

    /**
@var string The success message to display.
     */
    public $message = '%s items has been deleted';

    /**
{@inheritDoc}
     */
    public function handle(array $items)
    {
        $count = 0;
        foreach ($items as $item) {
            if ($item->delete()) {
                $count++;
            }
        }

        $this->sendReloadEvent();

        return $this->sendSuccess(sprintf($this->message, $count));
    }
}
```

## Attaching

Use the {{luya\admin\ngrest\base\NgRestModel::ngRestActiveSelections()}} method insde the desired [[ngrest-model.md]]:

```php
public function ngRestActiveSelections()
{
    return [
        [
            'label' => 'Archive Rows',
            'action' => function(array $items, \luya\admin\ngrest\base\ActiveSelection $context) {
                foreach ($items as $item) {
                    // do something with item. Each item is an ActiveRecord of the method implementation itself.
                }
  
                // if the selection interacts with the items, it might be necessary to reload the CRUD.
                $context->sendReloadEvent();

                return $context->sendSuccess('Done!');
            }
        ],
        [
            'class' => luya\admin\selections\DeleteActiveSelection::class,
        ]
    ];
}
```