# Admin Dashboard Objects

Dashboard objects are elements defined by your admin module attached to the Admin UI start dashboard screen. Basically the dashboard objects are returning a template which is feed by an api response.

All dashboard objects are defined inside the {{luya\admin\base\Module::$dashboardObjects}} property.

## Predefined Dashboards

You can choose from predefined dashboard objects, which are easy to implement:

+ {{luya\admin\dashboard\BasicDashboardObject}}
+ {{luya\admin\dashboard\TableDashboardObject}}
+ {{luya\admin\dashboard\ListDashboardObject}}

 ```php
public $dashboardObjects = [
    [
        'class' => 'luya\admin\dashboard\BasicDashboardObject',
        'template' => '<ul ng-repeat="item in data"><li>{{item.title}}</li></ul>',
        'dataApiUrl' => 'admin/api-news-article',
        'title' => 'Latest News',
    ],
    [
        // ... next object
    ]
];
```

In order to customize the template of a basic dashboard object you can override the  {{luya\admin\dashboard\BasicDashboardObject::$outerTemplate}}:

```php
[
    'class' => 'luya\admin\dashboard\BasicDashboardObject',
    'outerTemplate' => '<div class="wrap-around-template"><h1>{{title}}</h1><small>{{template}}</small></div>',
    'template' => '<ul ng-repeat="item in data"><li>{{item.title}}</li></ul>',
    'dataApiUrl' => 'admin/api-news-article',
    'title' => 'Latest News',
],
```

## Custom Dashboard Object

You can also write your own dashboard object make sure to extend {{luya\admin\base\DashboardObjectInterface}}