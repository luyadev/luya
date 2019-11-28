# Queue

> The LUYA admin module is required.

Since LUYA Admin version 2.0, the ([Yii Queue](https://github.com/yiisoft/yii2-queue) component is automatically registered and configured properly and is ready to handle jobs. The queue is also known as scheduler in admin context.

The component is configured as `adminqueue` based on the Database {{yii\queue\db\Queue}} integration. 

The admin module has a default integration for scheduling jobs when working with selects (dropdowns) and checkbox, so you are able to schedule those changes out of the box! See Checkbox (ToggleStatus) {{luya\admin\ngrest\plugins\ToggleStatus::$scheduling}} and Select {{luya\admin\ngrest\plugins\Select::$scheduling}}.

## Configure to run

There are 3 different options to enable to adminqueue, by default the admin queue is not configured to process jobs unless activated.

+ **"Fake Cronjob"**: On request in the frontend and admin the queue will be processed each 26 minutes.
+ **Cronjob**: Setup a cronjob which will run every minute (or less) to process the queue.
+ **Realtime Listen**: The `queue/listen` commands runs a seperate service and processed the queue in realtime.

### "Fake Cronjob" (Auto Bootstrap Queue)

The fake cron job will run each 25 minutes whether users request the websites in the frontend or sites are visited in the administration area. This is called a "fake cronjob" and should not be taken for large queue jobs. So take into account that frontend users might visit the website and process the queue. In order to enable the fake cronjob set {{luya\admin\Module::$autoBootstrapQueue}} to true, in the admin module config:

```php
'modules' => [
    'admin' => [
        'class' => 'luya\admin\Module',
        // ...
        'autoBootstrapQueue' => true,
    ]
]
```

The fake cronjob won't be executed on console (cli) commands. The information about last run timestamp is stored in {{luya\admin\models\Config}} with identifier {{luya\admin\models\Config::CONFIG_QUEUE_TIMESTAMP}}.

### Cronjob (admin/queue Command)

In shared hosting enviroments the best usage for the admins queue scheduler system is to setup a cronjob which runs every 5 minutes (ary at any other frequents depending on your needs). Make sure that {{luya\admin\Module::$autoBootstrapQueue}} is disabled un setup a cronjob with runs the {{luya\admin\commands\QueueController}} as `admin/queue` command:

```sh
/vendor/bin/luya admin/queue
```

### Realtime Listen

Since version 2.0.4 the native implementation of the [Yii Queue](https://github.com/yiisoft/yii2-queue) is bootstraped, therefore you might run all the commands from the original component. The most common use case is to process the queue in realtime, therfore the `queue/listen` command is used:

```sh
./vendor/bin/luya queue/listen --verbose=1
```

The verbose option helps to debug and should be disabled in production.

## Retry & Errors

The Queue is by default conigured to allow 5 retrys of an error job each 5 minutes. So assuming the exectued job fails (throws a {{luya\Exception}} for instance) the queue waits 5 minutes until a next try is executed. This will be done unit 5 trys are processed, then the job will be removed from the queue.

An exception is therefore the expected error format to ensure the job will retry again. If the exception is part of your application ensure to surround the job logic with a try catch block.