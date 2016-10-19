Error API Module
=========

For a strong and secure website, it is important to get access to all the errors and exceptions that occur in the background before your customer complain and make sure that it only happens once.

With the Error Api module, you can send all exceptions to your personal Error Api and get notify by email or Slack. If an exception occurs on the customer website, you will be notified with the full error stack and a slack notification will be sent (if configured).

### Module setup

add this line to your composer.json

```
"luyadev/luya-module-errorapi" : "^1.0@dev",
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

ITo enable the error api for your website, you need to configure the default LUYA error handler in the component section of your config file :

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
