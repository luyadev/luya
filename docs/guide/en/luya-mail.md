Luya Mail
===========
Luya is shipped with the PhpMailer component `mail`. You can access the mail component with `Yii::$app->mail` and start mailing. To configure the component inside your config u can override class properties in your config like this:

```php
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
```

Chain-Mode
-------------
To quickly send an email in one line you can use the code below.

```php
$mail = Yii::$app->mail->compose('Mail Subject', 'My HTML email content goes here.')->address('recipient@luya.io')->send();
```

the response value of `$mail` is a boolean value. If something happends wrong you can access the error inside the component like this:

```php
if (!$mail) {
	echo "Houston, we have problem: " . PHP_EOL;
	echo Yii::$app->mail->error();
} else {
	echo "Wow, mail has been sent!";
}
```

Object-Mode
-----------
As the mailer component is an object you can always access all methods in the mail component. This is very usefull when you are foreaching an array with recipients for example:

```php
// recipients array
$recipients = ['foo@luya.io', 'bar@luya.io'];
// mailer object
$mail = Yii::$app->mail;
$mail->compose('Mail Subject', 'My HTML email content goes here.');
foreach($recipients as $mail) {
	$mail->address($mail);
}
if (!$mail->send()) {
	echo "Houston, we have problem: " . PHP_EOL;
	echo Yii::$app->mail->error();
} else {
	echo "Wow, mail has been sent!";
}
```

Set PHPMailer values
----------------------------
If you want to access the phpmailer object you should use the Object-Mode which provides access to the `mailer()` method which is the PHPMailer Object. Here you find a list of [PHPMailer propertys](https://github.com/PHPMailer/PHPMailer#a-simple-example) you can set like in the example below:

```php
$mail = Yii::$app->mail;
$mail->compose('Mail Subject', 'My HTML email content goes here.');
$mail->address("foobar@luya.io", "John Doe");
$mail->mailer()->From = 'from@example.com';
$mail->mailer()->FromName = 'Mailer';
$mail->mailer()->addReplyTo('info@example.com', 'Information');
$mail->mailer()->addCC('cc@example.com');
$mail->mailer()->addBCC('bcc@example.com');
if (!$mail->send()) {
	echo "Houston, we have problem: " . PHP_EOL;
	echo Yii::$app->mail->error();
} else {
	echo "Wow, mail has been sent!";
}
```

