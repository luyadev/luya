# LUYA Mail Component

LUYA is shipped with a {{luya\components\Mail}} component who is using the PHPMailer. You can access the mail component with `Yii::$app->mail` and start sending mails. To configure the component u can override class properties in your config like this:

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

In order to test your configurations you can run the console command `health/mailer`. The command will try to connect to your mail server trough your provided credentials. By default the mailer component requires an SMTP Server and is not using the phpmail functions.

```
./vendor/bin/luya health/mailer
```

## Define a Mail Template

In order to define a HTML template for your mails, add `'layout' => '@app/views/maillayout.php'` to the mail component's configuration above.

Example template:

```php
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>My App</title>
</head>
<body>
<img src="<?= luya\helpers\Url::base(true); ?>/images/logo.png" />
<?= $content; ?>
</body>
</html>
```

{{\luya\helpers\Url::base}} can be used to get the absolute server URL.

## Compose new E-Mail

To quickly send an email in one line you can use the object chain mode like the example below:

```php
$mail = Yii::$app->mail->compose('Mail Subject', 'My HTML email content goes here.')->address('recipient@luya.io')->send();
```

You can also use the method `addresses` with an array of all E-Mail adresse you would like to address.

```php
Yii::$app->mail->compose('Subject', '<p>Html</p>')->addresses(['john@doe.com', 'Jane Doe' => 'jane@doe.com'])->send();
```

In order to add cc or bcc recipients you can use similar functions to {{\luya\components\Mail::addresses}}.

```php
bccAddresses(['john@doe.com', 'Jane Doe' => 'jane@doe.com'])
ccAddresses(['john@doe.com', 'Jane Doe' => 'jane@doe.com'])
```

The response value of `$mail` (actually its the response of the method `send()`) is a boolean value. If something happens wrong during the send process, you can access the error inside the component like following:

```php
if (!$mail) {
	echo "Houston, we have problem: " . PHP_EOL;
	echo Yii::$app->mail->error;
} else {
	echo "Wow, mail has been sent!";
}
```

## Using the PHPMailer Object

If you want to access the phpmailer object you should use the Object-Mode which provides access to the `mailer()` method which is the PHPMailer Object. Here you find a list of [PHPMailer propertys](https://github.com/PHPMailer/PHPMailer#a-simple-example) you can set like in the example below:

```php
$mail = Yii::$app->mail;
$mail->compose('Mail Subject', 'My HTML email content goes here.');
$mail->address("foobar@luya.io", "John Doe");
$mail->mailer->From = 'from@example.com';
$mail->mailer->FromName = 'Mailer';
$mail->mailer->addReplyTo('info@example.com', 'Information');
$mail->mailer->addCC('cc@example.com');
$mail->mailer->addBCC('bcc@example.com');
if (!$mail->send()) {
	echo "Houston, we have problem: " . PHP_EOL;
	echo Yii::$app->mail->error;
} else {
	echo "Wow, mail has been sent!";
}
```

