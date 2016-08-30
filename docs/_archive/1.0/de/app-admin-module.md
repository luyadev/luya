Projekt Admin-Modul
==================
Ein Admin-Modul biete dir die Möglichkeit in kürze eine komplexe Administrations oberfläch zu erstellen dazu benutzen Sie [NgRest Crud](app-admin-module-ngrest.md).

Eigene Views Rendern
--------------------
Erstellen Sie einen Controller unter `controllers` zbsp. `TestController.php`.

```php
class StatsController extends \luya\admin\base\Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}
```

Innerhalb der Administration welche via Angular und Rest geladen wird gibt es keine Layout Views innerhalb von AdminController, deshlab sollten Sie immer renderPartial verwenden.