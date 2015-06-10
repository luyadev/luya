send mails
===========

Configure the mail component inside your prep/prod config:

```php
return [
	'components' => [
		'mail' => [
			'host' => 'smtp.host.com',
			'username' => 'your@user.host.com',
			'password' => 'YourSmtpPassword',
			'from' => 'you@luya.io',
			'fromName' => 'Luya Admin',
			'altBody' => 'Your HTML ALT BODY'
		]
	]
];
```

short form with true/false response when using send() method.

```php
$mail = Yii::$app->mail->compose('Subject', '<h1>Html Content</h1><p>nice!</p>')->address('recipient@luya.io')->send();
 
if (!$mail) {
	echo "Error: " . \yii::$app->mail->error();
} else {
	echo "success!";
}
```

mailer object notation:

```php
$mailer = Yii::$app->mail;
$mailer->compose('Subject', '<h1>Html content</h1><p>nice!</p>');
$mailer->address("mail1@luya.io");
$mailer->address("mail2@luya.io". "John Doe");
if ($mailer->send()) {
	echo "success!";
} else {
	echo "Error: " . $mailer->error();
}
```

