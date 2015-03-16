send mails
===========

short form with true/false response when using send() method.

```php
$mail = \yii::$app->mail->compose('Subject', '<h1>Html Content</h1><p>nice!</p>')->address('recipient@luya.io')->send();
 
if (!$mail) {
	echo "Error: " . \yii::$app->mail->error();
} else {
	echo "success!;
}
```

mailer object notation:

```php
$mailer = \yii::$app->mail;
$mailer->compose('Subject', '<h1>Html content</h1><p>nice!</p>');
$mailer->address("mail1@luya.io");
$mailer->address("mail2@luya.io". "John Doe");
if ($mailer->send()) {
	echo "success!";
} else {
	echo "Error: " . $mailer->error();
}
```

Configure your mailer object inside the luya module based on yii modufe configuration behaviour. Below an example configuration.

```php
return [
	'modules' => [
		'luya' => [
			'class' => 'luya\Module',
			'mailerIsSMTP' => true,
			'mailerHost' => 'mail.example.com',
			'mailerUsername' => 'phpmail@example.com',
			'mailerPassword' => '******',
		]
		...
	]
	...
];
```