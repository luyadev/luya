Admin Styleguide
================

> TO BE TRANSLATED

Dieser kleine Styleguide ist eine Referenz für Komponenten die im Admin verwendet werden können.  
Zurzeit deckt dieser Styleguide nur das Thema Input Felder ab.


Input Felder
------------
Standardmässig wird das Label links vom Inputfeld dargestellt. Möchte man aus dieser Darstellung ausbrechen und das Label über das Input Feld setzen, muss man lediglich dem `.input` div die Klasse `.input--vertical` hinzufügen.  
  
Ein Beispiel:  
![input--text--vertical](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--text--vertical.jpg "Einfaches Inputfeld, Label darüber")

```
<div class="input input--text input--vertical">
    <label class="input__label" for="[input-id]">[input-label]</label>
    <div class="input__field-wrapper">
        <input class="input__field" id="[input-id]" name="[input-name]" type="text" placeholder="[input-placeholder]" />
    </div>
</div>
```

##### Einfacher Input
![input--text](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--text.jpg "Einfaches Inputfeld")

```
<div class="input input--text">
    <label class="input__label" for="[input-id]">[input-label]</label>
    <div class="input__field-wrapper">
        <input class="input__field" id="[input-id]" name="[input-name]" type="text" placeholder="[input-placeholder]" />
    </div>
</div>
```

##### Textarea
![input--textarea](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--textarea.jpg "Einfaches Textfeld")

```
<div class="input input--textarea">
    <label class="input__label" for="[textarea-id]">[textarea-label]</label>
    <div class="input__field-wrapper">
        <textarea class="input__field" id="[textarea-id]" name="[textarea-name]" placeholder="[textarea-placeholder]"></textarea>
    </div>
</div>
```

##### Select
![input--select](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--select.jpg "Select dropdown")

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
![input--radios](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--radios.jpg "Radio group")

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
![input--single-checkbox](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--single-checkbox.jpg "Alleinstehende Checkbox - Gut für Einstellungen (On / Off)")

```
<div class="input input--single-checkbox">
    <input id="[checkbox-id]" name="[checkbox-name]" type="checkbox" />
    <label class="input__label" for="[checkbox-id]">[checkbox-label]</label>
</div>
```

##### Checkboxes
![input--multiple-checkboxes](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/input--multiple-checkboxes.jpg "Checkbox Gruppe")

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

##### Icons mit Text / Buttons mit icons
Wenn man Icons inklusive Text verwenden möchte, muss das Icon je nach Ausrichtung die Klasse `left` oder `right` erhalten.

**Beispiel:**
```
<button class="btn-flat">Beispiel Label <i class="material-icons right">check</i></button>
```


Buttons
-------
Luya kann alle [Material-Design Buttons von Google](http://materializecss.com/buttons.html) verwenden.  
Bisher sind vier Variationen davon ausgehend definiert:

#####Default Buttons 
![Default button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn.png "Default Button")  
Eigenschaften:

* Die Default-Hintergrundfarbe wurde mit einem Grünton überschrieben (siehe Farben) und der Schriftfarbe weiss.
* Der Default-hover-Effekt wurde mit einem dunkleren Farbton überschrieben.

```
<button class="btn">
    Button default
</button>
```

##### "Flache" Buttons
![Flat button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn--flat.png "Flat Button")  
Im obigen Screenshot sind 3 flat buttons mit jeweils einem Icon aufgeführt. Da flat buttons keine Hintergrundfarbe und hover styles haben, eigenen Sie sich zur Darstellung von sekundären Funktionen.

Eigenschaften:

* Hat Standardmässig keinen Hintergrund und, bis auf die Veränderung des cursors (`cursor: pointer`), keinen Hover Effekt.

```
<button class="btn-flat">
    Button Flat
</button>
```

#####Kleine Buttons
![Small button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn--small.png "Kleine Button")  
Eigenschaften:

* Halbiertes Padding (1 satt 2rem).

```
<button class="btn btn--small">
    Button small
</button>
```

#####Fette-Buttons
![Bold button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn--bold.png "Fett Button")  
Eigenschaften:

* Font-weight ist hier bold(500).

```
<button class="btn btn--bold">
    Button bold
</button>
```

#####Runde Buttons
![Round button with icon](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/btn-floating.png "Runde Button mit Icon")  
Eigenschaften:  

* Überschreibungen wie der Default-Button.  

> **Achtung:** Kann nicht mit der btn--small Klasse kombiniert werden!

```
<button class="btn btn-floating">
    <i class="material-icons">done</i>
</button>
```


Info divs
---------

Folgende Info-Divs sind verfügbar:

**Info**
![alert alert--info](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/alert.alert--info.jpg "alert alert--info")  
```
<div class="alert alert--info">Lorem ipsum dolor sit amet...</div>
```

**Warnung**
![alert alert--warning](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/alert.alert--warning.jpg "alert alert--warning")  
```
<div class="alert alert--warning">Lorem ipsum dolor sit amet...</div>
```

**Erfolg**
![alert alert--success](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/alert.alert--success.jpg "alert alert--success")  
```
<div class="alert alert--success">Lorem ipsum dolor sit amet...</div>
```

**Fehler**
![alert alert--danger](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-admin-styles/alert.alert--danger.jpg "alert alert--danger")  
```
<div class="alert alert--danger">Lorem ipsum dolor sit amet...</div>
```

Badges
------

Es können die [Badges von Materialize](http://materializecss.com/badges.html) verwendet werden.

In der CRUD-Tabelle können diese Badges ebenfalls verwendet werden. In diesem Fall wird der Badge in der entsprechenden Spalte dargestellt, anstatt sich rechts an der Zeile auszurichten.


Tabellen
--------
Es können alle [Tabellen von Materialize](http://materializecss.com/table.html) verwendet werden.

```
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


Farben
------
Luya verwendet die [Farben vom Material-Design von Google](https://www.google.com/design/spec/style/color.html#).  
Farbschema:  

##### Bestätigungsfarbe Grün
Colorcode: #4CAF50  
Bzw. Farbe für die Meldung von gültigen Werten sowie für Schaltflächen mit empfohlenen Aktionen. 

##### Warnfarbe Rot:  
Colorcode: #EF5350  
Farbe für die Kennzeichnung eines Abbruchs oder zum Beispiel eines Fehlers

##### Luya Grundfarbe Blau:  
Colorcode: #2196F3  
Generelle Gestalltungsfarbe der Admin GUI  

- Hellblau-Variation:   
  Colorcode: #b3e5fc  
  Bearbeitetbare Elemente die sich noch im Initalzustand befinden



