# Active Buttons

Active Buttons are analog to [[ngrest-activewindow.md]] a button you can attach to a given ngrest CRUD row with a handler which can then interact with the Active Record class.

There are built in Acitve Buttons you can use and configure or you can create your own Active Buttons and attach them to an [[ngrest-model.md]].

## Creating an Active Button

There is a base class for all Active Buttons called {{luya\admin\ngrest\base\ActiveButton}}, the final implementation only requires a handler method.

An example Active Button which duplicates a row from the attached model.

```php
<?php

use luya\admin\ngrest\base\ActiveButton;

class DuplicateActiveButton extends ActiveButton
{
    public function getDefaultIcon()
    {
        return 'control_point_duplicate';
    }

    public function getDefaultLabel()
    {
        return 'Duplicate';
    }

    public function handle(NgRestModel $model)
    {
        $copy = clone $model;
        $copy->isNewRecord = true;
        foreach ($model->getPrimaryKey(true) as $field => $value) {
            unset($copy->{$field});
        }
        
        if ($copy->save()) {
            $this->sendReloadEvent();
            return $this->sendSuccess("A copy has been made.");
        }

        return $this->sendError("Error while duplicate the given model." . var_export($copy->getErrors(), true));
    }
}
```

The handle method must return {{luya\admin\ngrest\base\ActiveButton::sendSuccess()}} or {{luya\admin\ngrest\base\ActiveButton::sendError()}} in order to make a correct API response to the grid view.

Als you can triggere events for certain situations. Assuming you are going to modify the value of a column isnide this CRUD, a forced reload of the CRUD list can be done trough {{luya\admin\ngrest\base\ActiveButton::sendReloadEvent()}}.

## Attaching the Button

An Active Button can be attached inside every {{luya\admin\ngrest\base\NgRest}} model trough the {{luya\admin\ngrest\base\NgRest::ngRestActiveButtons()}} method.

```php
public function ngRestActiveButtons()
{
    return [
        ['class' => '\path\to\ActiveButtonClass'],
    ];
}
```
