LUYA admin 2.0.0 release

## Move to semver

With the new admin version we switch to strict semver versioning. This means we try to follow http://semver.org as good as possible.
Therefore the version constraint changed from `~` to `^` operator. As by the previous versioning system the admin module would become version 1.3, we skipped this plan and made 2.0 out of it. This will also be the case for all other modules which will have breaking changes in future.
The cms module will follow shorty after this release with version 2.0 as well.

So make sure to use the correct version constraint in order to profit from upcoming updates.

## Scheduler

By default the admin module now integrations the Yii Queue component. The Yii Queue is used for the new LUYA Scheduler system:

PICTURE

This is a new generic angular directive which turns any field into a scheduling option in order to plan the change of ANY value. Lets say you have a CRUD system with a stauts field "published", "archived", "draft", by now you can enable scheduling for this field which then let you change the value of the field for any given time or date in the future! No more need for datetime fields in order to setup display limitations. There are also cronjobs and a "fake cronjob" you can enable in order to run the queue without the setup of cronjobs but you have to turn it on by your own. This is vers usefull for small pages.

## NgRest Crud

We have strongly enhanced the CRUD system. Searching, Filtering and Sorting is now always context specific. So you can apply a filter and search in the results of the filter afterwards. There is also a new Tags view which lets you filter the content for tags. 

PICTURE

The tags view will automatically appear if the system detectes that your ngrest model has the Taggable Trait attached - this is how we think a system should work!

## Data Pools

With version 2.0 a new featured called "data pools" has arrived, this is something we very looking for internal for a long time. Its a common scenario to have data in the same table, but you want to display those data in 2 seperate CRUD systems. Therfore the table has commonly a field which is "type" or similar name. With the new `itemPoolApi` permission entry and ngRestPools() method you are able to display only data for this given type. This information about the pool will even passed to inherited curd realtion views!

PICTURE

## Api Request Logger

With this version we took a big step head for using the admin as headless API, therfore we have added a new request logger option you can enable in order to gather informations about the API Request. What are the slowesd urls? Which one is often v ery much so you might cache this request on the client?

PICTURE

## Updates

+ We have moved to latest version of Bootstrap 4 CSS Framework.
+ We have integrated unglue.io as compiling system for js and css, if you have not checked out unglue you should do imidieatly. Its a css and js compiler based on php, so you can install the binary via composer and start compiling right aways **without any use of node**!
+ Deprecated some classes and methods.
+ Improved API speed for Api users and also allowed more flexibility when creating custom API actions.
+ New sorting defintion option for CRUD views (for example relation attribute sorting setup).
+ Fixed a lot of smaller bugs.
+ Made small UI improvements (like reset icon for search etc.)
