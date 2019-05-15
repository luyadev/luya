LUYA admin 2.0.0 release

## Move to semver

With the new admin version we switch to strict semver versioning. This means we try to follow http://semver.org as good as possible.
Therefore the version constraint changed from `~` to `^` operator. As by the previous versioning system the admin module would become version 1.3, we skipped this plan and made 2.0 out of it. This will also be the case for all other modules with breaking changes in future.
The CMS module will follow shorty after this release with version 2.0 as well.

So make sure to use the correct version constraint in order to profit from upcoming updates.

## Scheduler

By default the Admin module now integrates the Yii Queue component. The Yii Queue is used for the new LUYA Scheduler system which.

![LUYA Admin Scheduler](https://raw.githubusercontent.com/luyadev/luya/master/docs/images/admin-scheduler.png)

This is a new generic Angular directive which turns any field into a scheduling option to plan the change of ANY value. Lets say you have a CRUD system with a stauts field "published", "archived" and "draft" by now you can enable scheduling for those fields which then let you change the value of the field for any given time or date in the future! No more need for datetime or timestamp fields in order to setup display limitations. There are is also a cronjob and a "fake cronjob" you can enable in order to run the queue without to setup of crontab but you have to turn it on by yourself in the configuration of the admin module.

## NgRest Crud

We have strongly enhanced the CRUD system. Searching, Filtering and Sorting is now always context specific. So you can apply a filter and search in the results of the filter afterwards. There is also a new Tags view which lets you filter the content for tags. 

![LUYA Admin Tags](https://raw.githubusercontent.com/luyadev/luya/master/docs/images/admin-tags.png)

The tags view will automatically appear if the system detects that your ngrest model has the Taggable Trait attached - this is how we think a system should work!

## Data Pools

With version 2.0 a new featured called "data pools" has arrived, this is something we where looking for internaly for a long time. Its a common scenario to have data in the same table, but you want to display those data in 2 seperate CRUD systems - as technically they are in the same table but the logic for the administration user could be different. Therfore the table has commonly a field with the "type". With the new `itemPoolApi` permission entry and ngRestPools() method you are now able to display only data for this given type. This information about the pool will even passed to inherited CRUD realtion viewsl, if available.

## Api Request Insight

With this version we took a big step ahead for using the admin as headless API, therefore we have added a new tool to take a deeper insight over all the reqests coming to the API. What are the slowest urls? Which API is called very often, so you might cache this request on the client?

![LUYA Admin Requests](https://raw.githubusercontent.com/luyadev/luya/master/docs/images/admin-requests.png)

In addition the LUYA headless client has been released as Version 2.0 with some new features and improvments. It was never easier to use LUYA Admin as a Data Provider for different websites, modules and applications.

## Updates

+ We have moved to latest version of Bootstrap 4 CSS Framework.
+ We have integrated unglue.io as compiling system for js and css, if you have not checked out unglue you should do imidieatly. Its a css and js compiler based on php, so you can install the binary via composer and start compiling right aways **without any use of node**!
+ Deprecated some classes and methods.
+ Improved API speed for Api users and also allowed more flexibility when creating custom API actions.
+ New sorting defintion option for CRUD views (for example relation attribute sorting setup).
+ Fixed a lot of smaller bugs.
+ Made small UI improvements (like reset icon for search etc.)
