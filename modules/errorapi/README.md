<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/internals/images/luya_logo_rc4.png" alt="LUYA Logo"/>
</p>

# Error API Module
[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Build Status](https://travis-ci.org/luyadev/luya-module-errorapi.svg?branch=master)](https://travis-ci.org/luyadev/luya-module-errorapi)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-luya-module-errorapi/downloads)](https://packagist.org/packages/luyadev/luya-module-errorapi)
[![Slack Support](https://github.com/luyadev/luya/tree/master/docs/guide/img/icons/Slack_Mark_Monochrome_Black.svg)](https://luyadev.slack.com/)

For a strong and secure website, it is important to get access to all the errors and exceptions that occur in the background before your customer complain and make sure that it only happens once.

With the Error Api module, you can send all exceptions to your personal Error Api and get notify by email or Slack. If an exception occurs on the customer website, you will be notified with the full error stack and a slack notification will be sent (if configured).

## Installation

For the installation of modules Composer is required.

### Composer

```
composer require luyadev/luya-module-errorapi:1.0.0-RC4
```
### Configuration

After installation via Composer include the module to your configuration file within the modules section.

```
'modules' => [
    // ...
    'errorapi' => [
        'class' => 'luya\errorapi\Module',
        'recipient' => ['errors@example.com'],
        'slackToken' => 'YOUR_SECRET_SLACK_TOKEN',
    ],
]
```

Defined the email of the recipient for the exceptions and setup the slack channel if needed too.

> Removing the slack part will disabled slack notifications.

To enable the error api for your website you need to configure the default LUYA error handler in the component section of your config file.

```
'components' => [
    // ...
    'errorHandler' => [
        'api' => 'https://example.com/errorapi', // where example is the domain you have setup error api above
        'transferException' => true',
    ],
]
```

### Initialization

After successfully installation and configuration run the migrate, import and setup command to initialize the module in your project.

1.) Migrate your database.

```sh
./vendor/bin/luya migrate
```

2.) Import the module and migrations into your LUYA project.

```sh
./vendor/bin/luya import
```

> It is very important to run the `./vendor/bin/luya migrate` and `./vendor/bin/luya import` commands in order for these changes to take effect.
