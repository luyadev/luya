LUYA Admin module release 1.2

## Security

Regarding a security audit from a swiss based security company we have made a few improvments only for security:

+ Unparsable Json Cruft: all json responses are now prepend with an unparsable cruft `[]|};` in order to prevent "json hijacking" (https://portswigger.net/blog/json-hijacking-for-the-modern-web).
+ The angular source code is now uglified and minified. Therefore angular strict di is now enabled by default.
+ If a user change the email in the admin, we have now an option which sends a token to the old email adress which has to be ented to change the current adress.
+ The admin login security token has now an expiration time and can be configured.
+ Login attempts are now tracked by the session (session based attemption limit) and if the user email is correct another limitation for user identifed login is available. After 5 attempts a lockout for 1 hour is enabled by default.
+ Max idle time of admin users can now be configured.

## General improvments

+ NgRest attributes can now display based on conditions, assuming you have a select with categories, it allows you to display field only when a category is select (https://github.com/luyadev/luya-module-admin/blob/master/src/ngrest/base/Plugin.php#L53-L71)
+ Filemanager provides option to switch between inline or download for file delivery, and renaming of files is possible to. We also have mode some improvments on file details as well as display full screen preview.
+ Storage system is now full swapable. Using amazon S3 is now possible and available: https://github.com/luyadev/luya-aws
+ Admin storage system speeed. We have significant reduced the speed in order to load all admin files and images.
+ Improved general PHP docs and removed deperecated methods see upgrade.md
+ Robot fonts now supports (+Extended), Cyrillic (+Extended), Greek (+Extended), Vietnamese.

You can download and install LUYA admin version 1.2 (`~1.2.0` in composer). Make sure to run the `migrate` command afterwards as it contains new database migrations. See the full [changelog] und [upgrade] document.


20 May 2018,
LUYA developer team
luya.io
