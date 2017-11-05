# CMS Layout

The CMS Layouts let the Content Management System know where to render the content blocks.

If you are using the CMS Module in your application (which is installed by default in the kickstarter application) then you can use the CMS Layouts.

## Create new Layout

All CMS Layouts are stored in the `views/cmslayouts` folder which is located in the base path of your project. If we create a new layout with 2 columns (for example) we just add a new view file to the cmslayouts folder like `views/cmslayouts/2columns.php`.

You can now add html content to the new cmslayout file *2columns.php* but the most important is to let the cms know on which part of the file the user can add content (blocks). To mark the area which can be filled with user content is called placeholder a can be defined with the $placeholders array `<?= $placeholders['YOUR_VARIABLE_NAME']; ?>`. In the example below we have made 2 placeholders for each column (left and right):

```php
<div class="row">
    <div class="col-md-6">
        <?= $placeholders['left']; ?>
    </div>
    <div class="col-md-6">
        <?= $placeholders['right']; ?>
    </div>
</div>
```

> Info: File names starting with *.* or *_* will be ignored. CMS Layouts in subfolders will be ignored to.

Since version RC4 you can also add a json file to configure the cmslayout for the admin view, this is optional and will also work without a json file. It can be very helpfull if you want to let the adminarea know how your layout structured with rows and columns, like a grid system.

In order to provide a json, use the same name es for the layout with the ending json, in our example *2columns.json*:

```json
{
    "rows" : [
        [
            {"cols": 8, "var": "left", "label": "Main content Left"},
            {"cols": 4, "var": "right", "label": "Sidebar Right"}
        ]
    ]
}
```

Now the administration area knows how the placeholder columns are structured, known from the bootstrap 4 grid system. The max amount of cols is 12.

You an also define multiple rows, here an advanced example for a layout with 4 placeholders:

```json
{
    "rows" : [
        [
            {"cols": 12, "var": "stage", "label": "Stage"},
        ],
        [
            {"cols": 8, "var": "left", "label": "Main content"},
            {"cols": 4, "var": "right", "label": "Sidebar"}
        ],
        [
            {"cols": 12, "var": "footer", "label": "Footer"},
        ],
    ]
}
```

## Import and Use

To enable the new cmslayout file, or after updating an existing layout file, you have to run the `import` command from the Terminal.

```sh
./vendor/bin/luya import
```

The import process will notify you what have been changed or added to your database:

```
luya\cms\admin\importers\CmslayoutImporter:
 - new 2columns.php main.php found and added to database.
```
