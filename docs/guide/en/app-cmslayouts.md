CMS Layout
==========
If you are using the CMS Module in your application (which is installed by default) then you can use the CMS Layouts.

All CMS Layouts are stored in the `views/cmslayouts` folder which is located in the base path of your project. If we create a new layout with 2 columns (for example) we just add a new twig template to the cmslayouts folder:

```
views/cmslayouts/2columns.twig
```

> All layout files are [Twig](http://twig.sensiolabs.org/) templates with suffix *.twig* to support parsing the files on import.

You can now add html content to the new cmslayout file *2columns.twig* but the most important is to let the cms know on which part of the file the user can add content (blocks). To mark the area which can be filled with user content defined the area with `{{placeholders.YOUR_VARIABLE_NAME}}`. In the example below we have made 2 placeholders for each column (left and right):

```html
<div class="row">
    <div class="col-md-6">
        {{placeholders.left}}
    </div>
    <div class="col-md-6">
        {{placeholders.right}}
    </div>
</div>
```

> You can use all [Luya Twig functions](luya-twig.md) in CMS Layouts.

You have now created a new cms layout which will be available after the import process.

Import and Use
--------------

To enable the new cmslayout file, or after updating an existing layout file, you have to run the `import` command from the Terminal.

```sh
./vendor/bin/luya import
```

The import process will notify you what have been changed or added to your database:

```
[layouts] => Array
(
    [main.twig] => existing cmslayout main.twig updated.
    [2columns.twig] => existing cmslayout 2columns.twig updated.
)
```

> The labels of the placeholder in the administration area can be changed under `CMS-Settings -> Layouts`.
