Admin Styleguide
================
Dieser kleine Styleguide ist eine Referenz für Komponenten die im Admin verwendet werden können.  
Zurzeit deckt dieser Styleguide nur das Thema Input Felder ab.

Input Felder
------------
Standardmässig wird das Label links vom Inputfeld dargestellt. Möchte man aus dieser Darstellung ausbrechen und das Label über das Input Feld setzen, muss man lediglich dem `.input` div die Klasse `.input--vertical` hinzufügen.  
  
Ein Beispiel:  
![input--text--vertical](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/app-admin-styles/input--text--vertical.jpg "Einfaches Inputfeld, Label darüber")

##### Einfacher Input
![input--text](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/app-admin-styles/input--text.jpg "Einfaches Inputfeld")

```
<div class="input input--text">
    <label class="input__label" for="[input-id]">[input-label]</label>
    <div class="input__field-wrapper">
        <input class="input__field" id="[input-id]" name="[input-name]" type="text" placeholder="[input-placeholder]" />
    </div>
</div>
```

##### Textarea
![input--textarea](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/app-admin-styles/input--textarea.jpg "Einfaches Textfeld")

```
<div class="input input--textarea">
    <label class="input__label" for="[textarea-id]">[textarea-label]</label>
    <div class="input__field-wrapper">
        <textarea class="input__field" id="[textarea-id]" name="[textarea-name]" placeholder="[textarea-placeholder]"></textarea>
    </div>
</div>
```

##### Select
![input--select](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/app-admin-styles/input--select.jpg "Select dropdown")

```
<div class="input input--select">
    <label class="input__label" for="[input-id]">[input-label]</label>
    <select class="input__field" id="[input-id]" name="[input-name]">
        <option selected="selected" value="0">[input-option-default]</option>
        <option value="m">[input-option-second]</option>
    </select>
</div>
```

##### Radio buttons
![input--radios](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/app-admin-styles/input--radios.jpg "Radio group")

```
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
![input--single-checkbox](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/app-admin-styles/input--single-checkbox.jpg "Alleinstehende Checkbox - Gut für Einstellungen (On / Off)")

```
<div class="input input--single-checkbox">
    <input id="[checkbox-id]" name="[checkbox-name]" type="checkbox" />
    <label class="input__label" for="[checkbox-id]">[checkbox-label]</label>
</div>
```

##### Checkboxes
![input--multiple-checkboxes](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/app-admin-styles/input--multiple-checkboxes.jpg "Checkbox Gruppe")

```
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

Icons
-----
Es können alle Icons des Material-Designs von Google verwendet werden.  
[https://www.google.com/design/icons/](https://www.google.com/design/icons/)

##### Standard Icons
| Zweck (Verknüpfte Aktion) | Icon                                                                          | Beispiel                                          |
| ------------------------- | ----------------------------------------------------------------------------- | ------------------------------------------------- |
| Speichern                 | [check](https://www.google.com/design/icons/#ic_check)                        | `<i class="material-icons">check</i>`             |
| Bearbeiten                | [create](https://www.google.com/design/icons/#ic_create)                      | `<i class="material-icons">create</i>`            |
| Löschen                   | [remove](https://www.google.com/design/icons/#ic_remove)                      | `<i class="material-icons">remove</i>`            |
| Abbrechen                 | [cancel](https://www.google.com/design/icons/#ic_cancel)                      | `<i class="material-icons">cancel</i>`            |
| Einstellungen             | [settings](https://www.google.com/design/icons/#ic_settings)                  | `<i class="material-icons">settings</i>`          |
| Hinzufügen (in Listen)    | [add](https://www.google.com/design/icons/#ic_add)                            | `<i class="material-icons">add</i>`               |
| Entfernen (in Listen)     | [remove](https://www.google.com/design/icons/#ic_remove)                      | `<i class="material-icons">remove</i>`            |
| Online                    | [cloud_queue](https://www.google.com/design/icons/#ic_cloud_queue)            | `<i class="material-icons">cloud_queue</i>`       |
| Offline                   | [cloud_off](https://www.google.com/design/icons/#ic_cloud_off)                | `<i class="material-icons">cloud_off</i>`         |
| Sichtbar                  | [visibility](https://www.google.com/design/icons/#ic_visibility)              | `<i class="material-icons">visibility</i>`        |
| Unsichtbar                | [visibility_off](https://www.google.com/design/icons/#ic_visibility_off)      | `<i class="material-icons">visibility_off</i>`    |

Buttons
-------
In Arbeit.

Tabellen
--------
In Arbeit.

Farben
------
In Arbeit.

