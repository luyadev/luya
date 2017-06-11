# Admin CSS Styles

This style guide is going to help you creating customized forms and buttons when working with the LUYA admin modules.

## Input Fields

##### Text Input

![input--text](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--text.jpg "Einfaches Inputfeld")

```html
<div class="input input--text">
    <label class="input__label" for="[input-id]">[input-label]</label>
    <div class="input__field-wrapper">
        <input class="input__field" id="[input-id]" name="[input-name]" type="text" placeholder="[input-placeholder]" />
    </div>
</div>
```

##### Textarea

![input--textarea](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--textarea.jpg "Einfaches Textfeld")

```html
<div class="input input--textarea">
    <label class="input__label" for="[textarea-id]">[textarea-label]</label>
    <div class="input__field-wrapper">
        <textarea class="input__field" id="[textarea-id]" name="[textarea-name]" placeholder="[textarea-placeholder]"></textarea>
    </div>
</div>
```

##### Select

![input--select](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--select.jpg "Select dropdown")

```html
<div class="input input--select">
    <label class="input__label" for="[input-id]">[input-label]</label>
    <select class="input__field" id="[input-id]" name="[input-name]">
        <option selected="selected" value="0">[input-option-default]</option>
        <option value="m">[input-option-second]</option>
    </select>
</div>
```

##### Radio buttons

![input--radios](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--radios.jpg "Radio group")

```html
<div class="input input--radios">
    <label class="input__label">[input-label]</label>
    <div class="input__field-wrapper">
        <input id="[radio-id-1]" name="[radio-name-1]" type="radio" value="[radio-value-1]"><label for="[radio-id-1]">[radio-label-1]</label> <br />
        <input id="[radio-id-2]" name="[radio-name-2]" type="radio" value="[radio-value-2]"><label for="[radio-id-2]">[radio-label-2]</label> <br />
        <input id="[radio-id-3]" name="[radio-name-3]" type="radio" value="[radio-value-3]"><label for="[radio-id-3]">[radio-label-3]</label>
    </div>
</div>
```

##### Single Checkbox

![input--single-checkbox](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--single-checkbox.jpg "Alleinstehende Checkbox - Gut für Einstellungen (On / Off)")

```html
<div class="input input--single-checkbox">
    <input id="[checkbox-id]" name="[checkbox-name]" type="checkbox" />
    <label class="input__label" for="[checkbox-id]">[checkbox-label]</label>
</div>
```

##### Checkboxes

![input--multiple-checkboxes](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--multiple-checkboxes.jpg "Checkbox Gruppe")

```html
<div class="input input--multiple-checkboxes">
    <label class="input__label">[input-label]</label>
    <div class="input__field-wrapper">
        <input id="[checkbox-id-1]" name="[checkbox-name-1]" type="checkbox" />
        <label for="[checkbox-id-1]">[checkbox-label-1]</label> <br />
        <input id="[checkbox-id-2]" name="[checkbox-name-2]" type="checkbox" />
        <label for="[checkbox-id-2]">[checkbox-label-2]</label> <br />
        <input id="[checkbox-id-3]" name="[checkbox-name-3]" type="checkbox" />
        <label for="[checkbox-id-3]">[checkbox-label-3]</label>
    </div>
</div>
```

#### Label above the form

By default all labels of forms are display on the left side with the input to the right. In order to use a the label above the input you can to the following: lediglich dem `.input` div die Klasse `.input--vertical` hinzufügen.  
  
Example form with label above:

![input--text--vertical](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--text--vertical.jpg "Einfaches Inputfeld, Label darüber")

```html
<div class="input input--text input--vertical">
    <label class="input__label" for="[input-id]">[input-label]</label>
    <div class="input__field-wrapper">
        <input class="input__field" id="[input-id]" name="[input-name]" type="text" placeholder="[input-placeholder]" />
    </div>
</div>
```

## Icons

We have implemented the google material design icons, you can check the reference for all icons [https://www.google.com/design/icons/](https://www.google.com/design/icons/).

##### Default Icons
| Usage (action context) | Icon                                                                          | Example                                          |
| ------------------------- | ----------------------------------------------------------------------------- | ------------------------------------------------- |
| Save                 | [check](https://www.google.com/design/icons/#ic_check)                        | `<i class="material-icons">check</i>`             |
| Edit                | [create](https://www.google.com/design/icons/#ic_create)                      | `<i class="material-icons">create</i>`            |
| Delete/trash                   | [remove](https://www.google.com/design/icons/#ic_remove)                      | `<i class="material-icons">remove</i>`            |
| Cance                 | [cancel](https://www.google.com/design/icons/#ic_cancel)                      | `<i class="material-icons">cancel</i>`            |
| Settings             | [settings](https://www.google.com/design/icons/#ic_settings)                  | `<i class="material-icons">settings</i>`          |
| Add (in Listen)    | [add](https://www.google.com/design/icons/#ic_add)                            | `<i class="material-icons">add</i>`               |
| Remove (in Listen)     | [remove](https://www.google.com/design/icons/#ic_remove)                      | `<i class="material-icons">remove</i>`            |
| Online                    | [cloud_queue](https://www.google.com/design/icons/#ic_cloud_queue)            | `<i class="material-icons">cloud_queue</i>`       |
| Offline                   | [cloud_off](https://www.google.com/design/icons/#ic_cloud_off)                | `<i class="material-icons">cloud_off</i>`         |
| Visible                  | [visibility](https://www.google.com/design/icons/#ic_visibility)              | `<i class="material-icons">visibility</i>`        |
| Invisible                | [visibility_off](https://www.google.com/design/icons/#ic_visibility_off)      | `<i class="material-icons">visibility_off</i>`    |

##### Icons and Buttons combination

If you are going to use icons within a text you have to pull them to a side, therefore use the predefined class `left` or `right`.

```html
<button class="btn-flat">Example Label <i class="material-icons right">check</i></button>
```

## Buttons

You can use all buttons from the [Materialize CSS Design Guide](http://materializecss.com/buttons.html):

##### Default Buttons 

![Default button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn.png "Default Button")  


```html
<button class="btn">
    Button default
</button>
```

##### Flat-Buttons

![Flat button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn--flat.png "Flat Button")  

```html
<button class="btn-flat">
    Button Flat
</button>
```

##### Small Buttons

![Small button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn--small.png "Kleine Button")  

```html
<button class="btn btn--small">
    Button small
</button>
```

##### Bold-Buttons

![Bold button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn--bold.png "Fett Button")  

```html
<button class="btn btn--bold">
    Button bold
</button>
```

##### Rounded-Buttons

![Round button with icon](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn-floating.png "Runde Button mit Icon")  

```
<button class="btn btn-floating">
    <i class="material-icons">done</i>
</button>
```

The rounded buttons can not be combined with the `btn--small` class.

Info divs
---------

**Info**

![alert alert--info](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/alert.alert--info.jpg "alert alert--info")  

```html
<div class="alert alert--info">Lorem ipsum dolor sit amet...</div>
```

**Warning**

![alert alert--warning](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/alert.alert--warning.jpg "alert alert--warning")  

```html
<div class="alert alert--warning">Lorem ipsum dolor sit amet...</div>
```

**Success**

![alert alert--success](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/alert.alert--success.jpg "alert alert--success")  

```html
<div class="alert alert--success">Lorem ipsum dolor sit amet...</div>
```

**Danger**

![alert alert--danger](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/alert.alert--danger.jpg "alert alert--danger")  

```html
<div class="alert alert--danger">Lorem ipsum dolor sit amet...</div>
```

## Badges

You can use all the [Badges from Materialize](http://materializecss.com/badges.html).

## Tables

You can use all the [Tables from Materialize](http://materializecss.com/table.html).

```html
<table class="striped responsive-table hoverable">
  <thead>
    <tr>
      <th>Table head 1 </th>
      <th>Table head 2 </th>
      <th>Table head 3 </th>
      <th>Table head 4 </th>
      <th>Table head 5 </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Table cell 1</td>
      <td>Table cell 2</td>
      <td>Table cell 3</td>
      <td>Table cell 4</td>
      <td>Table cell 5</td>
    </tr>
  </tbody>
</table>
```

## Colors

You can use the [Google Material Colors](https://www.google.com/design/spec/style/color.html#).  

+ Green: `#4CAF50`
+ Red: `#EF5350`
+ LUYA blue `#2196F3`
+ LUYA bright-blue `#b3e5fc`