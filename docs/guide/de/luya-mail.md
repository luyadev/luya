E-Mail Komponente
-----------------
*LUYA* kommt mit einer festdefinierten *E-Mail* Komponenten welche du über `Yii::$app->mail` erreichen kannst.

Voreinstellungen
----------------
Wenn du voreinstellungen wie *Absender* oder das *SMTP Passwort* ändern möchtest oder zusätzliche [Konfkugrationen konfigurieren](install-structures.md#beispiel-konfiguration) möchteste kannst du die `mail` komponententer unter `components` anpassen:

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

Hier werden einige Konfigurationen angepasst, es reicht jedoch meistens schon die SMTP Informationen zu setzen.

Schnelles versenden
-------------------
Um in einem 1-Zeiler ein E-Mail zusenden können Sie den *chain-mode* wie folgt benutzen

```php
$mail = Yii::$app->mail->compose('Mail Subject', 'My HTML email content goes here.')->address('recipient@luya.io')->send();
```

Wobei die Variabel `$mail` einnen *boolean* Wert erhaltet ob die Mail versendet wurde oder nicht. Um allfällige Fehler und verhalten auszulesen können Sie dies so machen:

```php
if (!$mail) {
    echo "Houston, we have problem: " . PHP_EOL;
    echo Yii::$app->mail->error();
} else {
    echo "Wow, mail has been sent!";
}
```

Erweitertes versenden
---------------------
Hier ein kleines Beispiel für einen erweitertetn E-Mail versand wobei mehrer Empfänger aus einem Array `$recipients` kommen:

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

PHPMailer Object
-----------------
Sie können auch zu jederzeit auf die [PHPMailer Mailer Klassse Eigenschaften](https://github.com/PHPMailer/PHPMailer#a-simple-example) zugreifen in dem Sie die `mailer()` funktione aufrufen und diese das PHPMailer Object zurück gibt.

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