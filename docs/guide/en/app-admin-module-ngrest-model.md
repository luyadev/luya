Admin Modul NgRest CRUD Model
=============================

*Luya* nutzt das [Yii2 Framework](http://www.yiiframework.com/doc-2.0/guide-README.html), daher wird das Model, bis auf das Handling von [NgRest Config](ng-rest.md), ebenfalls von Yii2 übernommen.

Daher sollen hier nur einige wichtige Methoden und Vorgehensweise vorgestellt werden, die vollständige Dokumentation finden Sie im [Yii2 Guide](http://www.yiiframework.com/doc-2.0/guide-README.html).

Model Input Validierung
=======================

Die Yii2 [Validierung](http://www.yiiframework.com/doc-2.0/guide-input-validation.html) wird über aufgestellte Validierungsregeln in der Methode `rules()` geregelt.

```php
public function rules()
{
    return [
        // name, email, subject and body Attribute werden als 'required'attributes are required
        [['name', 'email', 'subject', 'body'], 'required'],

        // the email attribute should be a valid email address
        ['email', 'email'],
    ];
}
```

Sie können die Validierung einzelner Felder auch Abhängig von anderen Felder machen:

```php
[
    ['state', 'required', 'when' => function($model) {
        return $model->country == 'USA';
    }],
]
```
