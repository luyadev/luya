Error API Module
=========

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

For a strong and secure website, it is important to get access to all the errors and exceptions that occur in the background before your customer complain and make sure that it only happens once.

With the Error Api module, you can send all exceptions to your personal Error Api and get notify by email or Slack. If an exception occurs on the customer website, you will be notified with the full error stack and a slack notification will be sent (if configured).

### Module setup

add this line to your composer.json and run the `composer install` command

```
"luyadev/luya-module-errorapi" : "1.0.0-RC3",
```

add the module to your application config:

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

Defined the email of the recipient for the exceptions and configure the slack channel if needed to. 

> Removing the slack part will disabled slack notifications.

### Website setup

To enable the error api for your website, you need to configure the default LUYA error handler in the component section of your config file :

```
'components' => [
	// ...
	'errorHandler' => [
		'class' => 'luya\web\ErrorHandler',
		'api' => 'https://example.com/errorapi', // where example is the domain you have setup error api above
		'transferException' => true',
	],
]
```

### Finalising the installation

Finally, to see the Error API Module in action, you need to run `./vendor/bin/luya migrate` and `./vendor/bin/luya import` commands and you're all set to receive errors and exceptions that occurred from your customer's website.

> It is very important to run the `./vendor/bin/luya migrate` and `./vendor/bin/luya import` commands in order for these changes to take effect.
