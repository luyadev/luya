!WIP

LUYA admin 3.0.0 release

## 2FA with OTP Option

![LUYA 2FA](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/2fa.png)

Yes! You can now setup 2 factor authentication for your account without the need of sending tokens by email. If email secure login is setup, but users choose to use the OTP 2fa way, no email with a token will be sent. There is not more to say on this.

## Remember Device

![LUYA Devices](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/devices.png)

With version 3.0 its now possible to remeber a certain devices for a given amount of days. This means if the *remember this device* checkbox has been toggle during login process, you will be auto logged in for a certain amount of days on this device without asking for password or email. If you idle for to long and the admin kicks you off, the cookie with this information will be destroyed and the device will be removed from the list againi. So don't fall asleep while typing. To understand how this works, the LUYA admin will stored an device specific unique token in a cookie that will be retreived when open the admin ui.

## New Account View

![LUYA Account overhaul](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/account.png)

The account view recieved a small overhaul with accordions, an element which is widely used in the admin ui (its an angularjs directive called ` <collapse-container title="Advanced Settings">Content</collapse-container>` you can use it everywhere in your custom luya code.).

## Queue Errors

The integration with Yii Queue gets even deeper. Exceptions which are thrown while queue run are now logged for each retry. Even the job was successfull at the end, all thrown exceptions and error will be stored and are visible. This makes it more easy to debug queue jobs.

## "Forgot your password?"

![LUYA Account overhaul](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/reset-password.png)

A new button "forgot your password" has been added to the login screen, only if enabled in the admin module configuration. By default its disabled due to a small security risk. In order to enable the new option set LUYA admin module propety `$resetPassword` to true.

## Session based lockout is now IP based lockout

In the previous version we have integrated a session based lockout. If you where attempting to login for a certain amount your session profile have been locked out. As its easy to clear session date, we have now implemented an ip based lockout. Its also possible to switch ips but its better then session based lockout. If brute forcing is the method of attack, and the mail adresse has been breached, the email based lockout will step into action anyhow.

Please check the full [Changelog](https://github.com/luyadev/luya-module-admin/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://github.com/luyadev/luya-module-admin/blob/master/UPGRADE.md) where you will find a list of all breaking changes.

February 2020, LUYA developer team