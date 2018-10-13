# Storage Component

The storage component provies the possibility to upload files and images, also apply filters to images.

In general the storage component is configure by default and available via `Yii::$app->storage`. The main component where all configuration options are display is the {{luya\admin\storage\BaseFileSystemStorage}}.

As storage can have different faces, for example local storage where all files are stored in `@webroot/storage` or an [Amazon S3](https://github.com/luyadev/luya-aws) Adapter which stores all files in an Amazon S3 Bucket, by default the {{luya\admin\storage\LocalFileSystem}} is implement and configured.

This is the default configuration your config:

```php
return [
    // ...
    'components' => [
        'storage' => [
            'class' => 'luya\admin\storage\LocalFileSystem',
        ],
    ]
]
```

This means the storage system is always a direct implementation of what type of file system is used.

Here is an example file configuration if you need to have the option to upload insecure files like csv or svgs:

```php
return [
    // ...
    'components' => [
        'storage' => [
            'class' => 'luya\admin\storage\LocalFileSystem',
            'whitelistExtensions' => ['csv', 'svg'],
            'whitelistMimeTypes' => ['text/plain'], // as this is the mime type for csv files
         ]
    ]
]
```

## Upload Files

TBD

Take a look at {{luya\admin\storage\BaseFileSystemStorage}}.

## Upload Images

TBD

Take a look at {{luya\admin\storage\BaseFileSystemStorage}}.
