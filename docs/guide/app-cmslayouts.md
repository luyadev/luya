# CMS Layout

The CMS layouts let the "Content Management System" know where to render the content blocks.

If you are using the CMS module in your application (which is installed by default in the LUYA kickstarter application) then you can use the CMS layouts.

![CMS Layouts](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/cmslayouts.png "CMS Layouts")

## Create new Layout

All CMS layouts are stored in the `views/cmslayouts` folder which is located in the base path of your project. If we create a new layout with e.g. 2 columns we just add a new view file to the cmslayouts folder like `views/cmslayouts/2columns.php`.

You can now add html content to the new CMS layout file `2columns.php` but the most important is to let the CMS know on which part of the file the user can add content (blocks). To mark the area which can be filled with user content is called placeholder a can be defined with the $placeholders array `<?= $placeholders['YOUR_VARIABLE_NAME']; ?>`. In the example below we have made 2 placeholders for each column (left and right):

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

> Info: File names starting with *.* or *_* will be ignored. CMS layouts in sub folders will be ignored too.

Since LUYA version RC4 you can also add a json file to configure the CMS layout for the admin view, this is optional and will also work without a json file. It can be very helpful if you want to let the Admin UI know how your layout is structured with rows and columns, e.g. like a grid system.

In order to provide a json, use the same name as for the layout with the ending `.json`, in our example `2columns.json:

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

Now the administration area knows how the placeholder columns are structured based on the the bootstrap4 grid system. The max amount of cols is 12.

You an also define multiple rows, here an advanced example for a layout with 4 placeholders:

```json
{
    "rows" : [
        [
            {"cols": 12, "var": "stage", "label": "Stage"}
        ],
        [
            {"cols": 8, "var": "left", "label": "Main content"},
            {"cols": 4, "var": "right", "label": "Sidebar"}
        ],
        [
            {"cols": 12, "var": "footer", "label": "Footer"}
        ]
    ]
}
```

> If a json file is used for the CMS layout the addition of new placeholders must be available in the json file as well as this will be the priority source for importing CMS layouts.

## Provide CMS Layouts

There are two ways of defining a cmslayout in order for importing them. Either use the folder structure, where it requires a folder named `cmslayouts` or there is an option to defined them inside the {{luya\cms\admin\Module::$cmsLayouts}} property.

```php
'cmsadmin' => [
    'class' => 'luya\cms\admin\Module',
    'cmsLayouts' => [
          '@app/path/to/cmslayouts', // a folder with layout files
          '@app/file/TheCmsLayout.php', // a layout file
     ],
]
```

## Import and use

To enable the new CMS layout file or after updating an existing layout file you have to run the `import` command from the terminal.

```sh
./vendor/bin/luya import
```

The import process will notify you what have been changed or added to your database:

```
luya\cms\admin\importers\CmslayoutImporter:
 - new 2columns.php main.php found and added to database.
```
