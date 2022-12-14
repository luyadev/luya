LUYA admin 2.0.0 release

## Move to semver

With this new version of the LUYA admin, we switch to strict semver versioning. This means that we will try to follow https://semver.org as good as possible.
Therefore the version constraint changed from the `~` to the `^` operator. With the previous versioning system, the admin module would have become version 1.3, with the new one it will be 2.0. This will also be the case for all other modules with breaking changes in the future (the CMS module will follow shortly with version 2.0 as well).

So make sure to use the correct version constraint in order to profit from upcoming updates.

## Scheduler

The admin module now integrates the Yii Queue component upon which the new LUYA Scheduler is built.

![LUYA Admin Scheduler](https://raw.githubusercontent.com/luyadev/luya/master/docs/images/admin-scheduler.png)

This is a new generic Angular directive which turns any field into a scheduling option to plan the change of ANY value. Let's assume you have a CRUD system with a status field and its possible values "published", "archived" and "draft". Now you can enable scheduling for this field in order to have its value automatically changed at any given date and time in the future. No more need for datetime or timestamp fields in order to setup display limitations. You can enable a cronjob or have the system run a "fake cronjob" (which has to be turned on in the configuration of the admin module) in order to process the queue.

## Data Notifications

Also new is a notification system that highlights CRUD lists with new data added since your last visit, either through the administration or a frontend form. In order to receive these notifications, you simply have to visit a CRUD view once. This is especially interesting for frontend-generated inputs. As the notifications are only automatically enabled for visited CRUD views, the system will not overwhelm and annoy users with notifications that are not of interest to them – this is important with different users working in different sections.

![LUYA Admin Notifications](https://raw.githubusercontent.com/luyadev/luya/master/docs/images/admin-notifications.png)

And, of course, you can turn off these notifications for any CRUD view with a single click.

## NgRest CRUD

We have strongly enhanced the CRUD system. Searching, filtering and sorting is now context specific. So you can apply a filter and search in the results of the filter afterwards. There is also a new tags view which lets you filter the content by tags. 

![LUYA Admin Tags](https://raw.githubusercontent.com/luyadev/luya/master/docs/images/admin-tags.png)

The tags view will automatically be displayed if the system detects that your ngrest model has the Taggable Trait attached.

## Data Pools

With version 2.0 we introduce a new feature called "data pools" (this has been on our list for a long time). It's a common scenario to combine data in one table that should be managed in separate CRUD views. An example would be events on a website that includes both a public area and an intranet – you might want to keep the data separate in different CRUD views for the admin users (possibly with different field listings and program logic) while technically it is stored in the same table.

To enable data pools for a table, it usually has a field to distinguish the pool a record belongs to. With the new `itemPoolApi` permission entry and the ngRestPools() method you are now able to display only data for a given pool. The information about the pool will even be passed to CRUD relation views, if available.

## Api Request Insight

With this version we took a big step forward for using the admin as a headless API, therefore we have added a new tool to allow deeper insights into the requests coming to the API. What are the slowest URLs? Which API is called often? This helps you evaluate the requests that should be cached on the client.

![LUYA Admin Requests](https://raw.githubusercontent.com/luyadev/luya/master/docs/images/admin-requests.png)

In addition, the LUYA headless client has been released as version 2.0, too, with some new features and improvements. It was never easier to use LUYA admin as a data provider for different websites, modules and applications!

## Updates

+ We have upgraded to the latest version of the Bootstrap 4 framework.
+ We have integrated unglue.io as a compiling system for JavaScript and CSS (if you have not checked out unglue, you should definitely do so). The compiler is based on PHP, so you can install the binary via composer and start compiling right away **without any use of Node.js**!
+ Improved API speed for API users and also allowed more flexibility when creating custom API actions.
+ New sorting definition option for CRUD views (for example relation attribute sorting setup).
+ Provide new reloadButton option to set custom reload events (for example call clear cache url in frontend).
+ Fixed a lot of smaller bugs.
+ Made small UI improvements (like reset icon for search etc.).

Please check the full [Changelog](https://github.com/luyadev/luya-module-admin/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://github.com/luyadev/luya-module-admin/blob/master/UPGRADE.md) where you will find a list of all breaking changes.

May 2019, LUYA developer team