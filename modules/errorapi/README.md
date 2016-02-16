Error API
=========

To create strong and secure website its important to know all exceptions before your customer knows the exceptions and to make sure the exception happends only once. For this we provide the Error Api module where you can send all exceptions to your personal Error Api. If an exception happens on the customers website you will get a mail with the full stack and a slack notification (if configured).

### install

add to your composer.json

```
"zephir/luya-module-errorapi" : "1.0.0-beta5",
```

add the module to your application config:

```
'modules' => [
	// ...
	'errorapi' => [
	    'class' => 'errorapi\Module',
	    'recipient' => ['errors@example.com'],
	    'slackToken' => 'YOUR_SECRET_SLACK_TOKEN',
	],
]
```

Defined the recipients of the exception mail and configuration the slack channel, if you like to (removing the slack part will disabled slack notification).

### setup your website

In order to enable the above created error api for your website you just have to configure the default LUYA error handler in the config file in the component section of your Project:

```
'components' => [
	// ...
	'errorHandler' => [
		'class' => 'luya\web\ErrorHandler'
		'api' => 'https://example.com/errorapi' // where example is the domain you have setup error api above
	],
]
```