# NgRest Pools

> Available since luya-module-admin version 2.0

See {{luya\admin\ngrest\base\NgRestModel::ngRestPools()}}

## Define data pools

> The difference between ngRestFilters() and ngRestPools() is that the pool identifer must be provided in the menu component and is not visible in the
> UI, it is like an invisible filter, only available to developers.

A data pool can be used to retrieve only a subset of data. The identifier for the pool is passed trough to all subrelation
calls. Related models will filter their data by the same pool identifier, if configured accordingly.

The following is an example of a pool identifier for a table with cars:

```php
return [
    'poolAudi' => ['car_brand' => 'Audi'],
    'poolBMW' => ['car_brand' => 'BMW'],
];
```

If the pool identifier is defined in the menu, all subrelation calls will receive the identifer. Thefore, in the above example, you could have a model for
car parts that only returns parts with the same pool identifier in relation calls:

```php
return [
    'poolAudi' => ['parts_brand' => 'Audi'],
    'poolBMW' => ['parts_brand' => 'BMW'],
];
```

The identifiers `poolAudi` and `poolBMW` are passed to the `parts` table to only return parts for the given car brand.

> The pool condition is threaded as where condition, the above example would be `where(['car_brand' => 'BMW'])`. Only hash format expression with "equal" operators are allowed.
