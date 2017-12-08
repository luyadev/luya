<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/internals/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# REMOTE Admin Module

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-module-remoteadmin/v/stable)](https://packagist.org/packages/luyadev/luya-module-remoteadmin)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-remoteadmin/downloads)](https://packagist.org/packages/luyadev/luya-module-remoteadmin)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

**The powerful tool for Agencies!**

*What is REMOTE ADMIN?* Well, have you ever created several websites with the same system and delivered them to different Providers? Remote Admin provides you the ability to collect all your [LUYA](https://github.com/zephir/luya#readme) Websites into the REMOTE ADMIN and helps you to see:

+ See all outdated websites (auto compare LUYA version to the lastet version available on packagist).
+ Collect informations about the Website itself, to make sure they are configured well.
+ See how many administrators are active.
+ Direct Link to the Website.

We will add more features in future, to make the [LUYA](https://github.com/zephir/luya#readme) control panel a powerfull tool!

![Remote Admin](https://raw.githubusercontent.com/luyadev/luya-module-remoteadmin/master/remote-admin.png)


Remote Admin will work out of the box with all [LUYA](https://github.com/zephir/luya#readme) instances you create, just add a `remoteToken` in your project application config and install the remoteadmin module on your privat/company Server/Website and you are able to add all instances.

## Installation

For the installation of modules Composer is required.

```
composer require luyadev/luya-module-remoteadmin:1.0.0-RC4,
```

## Configuration

```
'remoteadmin' => [
    'class' => 'luya\remoteadmin\Module'
],
```

> Remoteadmin requires the LUYA Admin module

Login into your admin interface and your are ready to add LUYA instances.


### Instance Setup

add a remote token to the application you want to control:

```
'remoteToken' => 'ADD_YOUR_SECRET_STRONG_TOKEN_HERE',
```

> Use http://passwordsgenerator.net to generate a strong token

Now you are able to add this instance to your remote admin with the above added remoteToken.
