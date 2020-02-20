LUYA admin 3.0.0 release

## Two-Factor Authentication with OTP (One-Time Password)

![LUYA 2FA](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/2fa.png)

You can now set up two-factor authentication for your account, rendering the need to send access tokens by email unnecessary. If secure login is set up, no access tokens will be sent to users with active two-factor authentication and OTP.

## Remember Device

![LUYA Devices](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/devices.png)

With version 3.0 it is now possible to remember devices: If the *remember this device* checkbox is ticked on login, you will be logged in automatically for a certain amount of days on this device without being asked for a password or access token. How does this work? LUYA will store a device-specific unique token in a cookie that will be retrieved when accessing the admin ui. If you are inactive for too long and the admin logs you out, the cookie with this information will be destroyed and the device will be removed from the list of remembered devices. So better don't fall asleep while typing. ;-)

## Updated Account View

![LUYA Account overhaul](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/account.png)

The account view received a small overhaul with accordions, an element widely used in the admin ui (it's an AngularJS directive that you can use everywhere in your custom LUYA code: `<collapse-container title="Advanced Settings">Content</collapse-container>`).

## Improved Queue Errors

The integration with Yii Queue gets even deeper: Exceptions thrown while the queue is running are now logged for each retry. Even when a job is finished successfully in the end, all exceptions and errors thrown while processing the job are stored and visible. This makes it much easier to debug queue jobs!

## "Forgot Your Password?"

![LUYA Account overhaul](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/reset-password.png)

Finally! A new button "Forgot Your Password?" is added to the login screen when enabled in the admin module configuration. By default it is disabled due to a small security risk. In order to enable the new option, set the LUYA admin module property `$resetPassword` to true.

By the way, if you would like to have a random image as a background of the login screen, simply install the login image extension https://luya.io/packages/nadar--luya-login-image.

## Session Based Lockout Is Now IP Based Lockout

In the previous version of the LUYA admin we had integrated a session based lockout: If you failed to login a certain amount of tries, your session profile was locked out. As it is rather easy to clear session data, we have now implemented an IP based lockout. While it would still be possible to switch IPs, this method is preferred to session based lockout. In case of a brute-force attack and a breach of the email address, the email based lockout will take effect.

Please check the full [Changelog](https://github.com/luyadev/luya-module-admin/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://github.com/luyadev/luya-module-admin/blob/master/UPGRADE.md) where you will find a list of breaking changes.

February 2020, LUYA developer team
