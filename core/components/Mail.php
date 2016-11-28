<?php

namespace luya\components;

use Yii;
use Exception;
use PHPMailer;
use SMTP;

/**
 * LUYA mail component to compose messages and send them via SMTP.
 *
 * This component is registered on each LUYA instance, how to use:
 *
 * ```php
 * if (Yii::$app->mail->compose('Subject', 'Message body of the Mail'->adress('info@example.com')->send()) {
 *     echo "Mail has been sent!";
 * } else {
 *     echo "Error" : Yii::$app->mail->error;
 * }
 * ```
 *
 * SMTP debug help:
 *
 * ```
 * swaks -s HOST -p 587 -ehlo localhost -au AUTH_USER -to TO_ADRESSE -tls
 * ```
 *
 * @property \PHPMailer $mailer The PHP Mailer object
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Mail extends \yii\base\Component
{
    private $_mailer = null;

    /**
     * @var string sender email address
     */
    public $from = 'php@zephir.ch';

    /**
     * @var string sender name
     */
    public $fromName = 'php@zephir.ch';

    /**
     * @var string email server host address
     */
    public $host = 'mail.zephir.ch';

    /**
     * @var string email server username
     */
    public $username = 'php@zephir.ch';

    /**
     * @var string email server password
     */
    public $password = null; // insert password

    /**
     * @var bool disable if you want to use old PHP sendmail
     */
    public $isSMTP = true;

    /**
     * @var string alternate text message if email client doesn't support HTML
     */
    public $altBody = 'Please use a HTML compatible E-Mail-Client to read this E-Mail.';

    /**
     * @var int email server port
     */
    public $port = 587;

    /**
     * @var bool enable debug output mode 'Data and commands'
     */
    public $debug = false;
    
    /**
     * @var string Posible values are `tls` or `ssl`
     */
    public $smtpSecure = 'tls';
    
    /**
     * @since 1.0.0-beta7
     * @var string|boolean Define a layout template file which is going to be wrapped around the setBody()
     * content. The file alias will be resolved so an example layout could look as followed:
     *
     * ```php
     * $layout = '@app/views/maillayout.php';
     * ```
     *
     * In your config or any mailer object. As in layouts the content of the mail specific html can be access
     * in the `$content` variable. The example content of `maillayout.php` from above could look like this:
     *
     * ```php
     * <h1>My Company</h1>
     * <div><?= $content; ?></div>
     * ```
     */
    public $layout = false;
    
    /**
     * Getter for the mailer object
     *
     * @return \PHPMailer
     */
    public function getMailer()
    {
        if ($this->_mailer === null) {
            $this->_mailer = new PHPmailer;
            $this->_mailer->CharSet = 'UTF-8';
            $this->_mailer->From = $this->from;
            $this->_mailer->FromName = $this->fromName;
            $this->_mailer->isHTML(true);
            $this->_mailer->AltBody = $this->altBody;
            // if sending over smtp, define the settings for the smpt server
            if ($this->isSMTP) {
                if ($this->debug) {
                    $this->_mailer->SMTPDebug = 2;
                }
                $this->_mailer->isSMTP();
                $this->_mailer->SMTPSecure = $this->smtpSecure;
                $this->_mailer->Host = $this->host;
                $this->_mailer->SMTPAuth = true;
                $this->_mailer->Username = $this->username;
                $this->_mailer->Password = $this->password;
                $this->_mailer->Port = $this->port;
                $this->_mailer->SMTPOptions = [
                    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true],
                ];
            }
        }

        return $this->_mailer;
    }
    
    /**
     * Reset the mailer object to null
     *
     * @return void
     */
    public function cleanup()
    {
        $this->_mailer = null;
    }
    
    /**
     * Compose a new mail message, this will first flush existing mailer objects
     *
     * @param string $subject The subject of the mail
     * @param string $body The HTML body of the mail message.
     * @return \luya\components\Mail
     */
    public function compose($subject, $body)
    {
        $this->cleanup();
        $this->setSubject($subject);
        $this->setBody($body);
        return $this;
    }
    
    /**
     * Set the mail message subject of the mailer instance
     *
     * @param string $subject The subject message
     * @return \luya\components\Mail
     */
    public function setSubject($subject)
    {
        $this->getMailer()->Subject = $subject;
        return $this;
    }
    
    /**
     * Set the HTML body for the mailer message, if a layout is defined the layout
     * will automatically wrapped about the html body.
     *
     * @param string $body The HTML body message
     * @return \luya\components\Mail
     */
    public function setBody($body)
    {
        $this->getMailer()->Body = $this->wrapLayout($body);
        return $this;
    }

    /**
     * Wrap the layout from the `$layout` propertie and store
     * the passed  content as $content variable in the view.
     *
     * @param string $content The content to wrapp inside the layout.
     */
    protected function wrapLayout($content)
    {
        // do not wrap the content if layout is turned off.
        if ($this->layout === false) {
            return $content;
        }
        
        $view = Yii::$app->getView();
        return $view->renderPhpFile(Yii::getAlias($this->layout), ['content' => $content]);
    }
    
    /**
     * Add multiple addresses into the mailer object.
     *
     * If no key is used, the name is going to be ignored, if a string key is available it represents the name.
     *
     * ```php
     * adresses(['foo@example.com', 'bar@example.com']);
     * ```
     *
     * or with names
     *
     * ```php
     * adresses(['John Doe' => 'john.doe@example.com', 'Jane Doe' => 'jane.doe@example.com']);
     * ```
     *
     * @return \luya\components\Mail
     * @since 1.0.0-beta4
     * @param array $emails An array with email adresses or name => email paring to use names.
     */
    public function adresses(array $emails)
    {
        foreach ($emails as $name => $mail) {
            if (is_int($name)) {
                $this->address($mail);
            } else {
                $this->address($mail, $name);
            }
        }
        
        return $this;
    }
    
    /**
     * Correct spelled alias method for `adresses`.
     *
     * @todo remove wrong spelled on release
     * @param array $emails
     * @return \luya\components\Mail
     */
    public function addresses(array $emails)
    {
        return $this->adresses($emails);
    }
    
    /**
     * Add a single address with optional name
     *
     * @param string $email The email address e.g. john@example.com
     * @param string $name The name for the address e.g. John Doe
     * @return \luya\components\Mail
     */
    public function address($email, $name = null)
    {
        $this->getMailer()->addAddress($email, (empty($name)) ? $email : $name);

        return $this;
    }

    /**
     * Add multiple CC addresses into the mailer object.
     *
     * If no key is used, the name is going to be ignored, if a string key is available it represents the name.
     *
     * ```php
     * ccAddresses(['foo@example.com', 'bar@example.com']);
     * ```
     *
     * or with names
     *
     * ```php
     * ccAddresses(['John Doe' => 'john.doe@example.com', 'Jane Doe' => 'jane.doe@example.com']);
     * ```
     *
     * @return \luya\components\Mail
     * @since 1.0.0-RC2
     * @param array $emails An array with email addresses or name => email paring to use names.
     */
    public function ccAddresses(array $emails)
    {
        foreach ($emails as $name => $mail) {
            if (is_int($name)) {
                $this->ccAddress($mail);
            } else {
                $this->ccAddress($mail, $name);
            }
        }

        return $this;
    }

    /**
     * Add a single CC address with optional name
     *
     * @param string $email The email address e.g. john@example.com
     * @param string $name The name for the address e.g. John Doe
     * @return \luya\components\Mail
     */
    public function ccAddress($email, $name = null)
    {
        $this->getMailer()->addCC($email, (empty($name)) ? $email : $name);

        return $this;
    }

    /**
     * Add multiple BCC addresses into the mailer object.
     *
     * If no key is used, the name is going to be ignored, if a string key is available it represents the name.
     *
     * ```php
     * bccAddresses(['foo@example.com', 'bar@example.com']);
     * ```
     *
     * or with names
     *
     * ```php
     * bccAddresses(['John Doe' => 'john.doe@example.com', 'Jane Doe' => 'jane.doe@example.com']);
     * ```
     *
     * @return \luya\components\Mail
     * @since 1.0.0-RC2
     * @param array $emails An array with email addresses or name => email paring to use names.
     */
    public function bccAddresses(array $emails)
    {
        foreach ($emails as $name => $mail) {
            if (is_int($name)) {
                $this->bccAddress($mail);
            } else {
                $this->bccAddress($mail, $name);
            }
        }

        return $this;
    }

    /**
     * Add a single BCC address with optional name
     *
     * @param string $email The email address e.g. john@example.com
     * @param string $name The name for the address e.g. John Doe
     * @return \luya\components\Mail
     */
    public function bccAddress($email, $name = null)
    {
        $this->getMailer()->addBCC($email, (empty($name)) ? $email : $name);

        return $this;
    }

    /**
     * Trigger the send event of the mailer
     *
     * @return boolean
     */
    public function send()
    {
        return $this->getMailer()->send();
    }

    /**
     * Get the mailer error info if any.
     *
     * @return string
     */
    public function getError()
    {
        return $this->getMailer()->ErrorInfo;
    }

    /**
     * @see https://github.com/PHPMailer/PHPMailer/blob/master/examples/smtp_check.phps
     *
     * @throws Exception
     */
    public function smtpTest($verbose)
    {
        //Create a new SMTP instance
        $smtp = new SMTP();
        
        if ($verbose) {
            // Enable connection-level debug output
            $smtp->do_debug = 3;
        }
        
        try {
            // connect to an SMTP server
            if ($smtp->connect($this->host, $this->port)) {
                // yay hello
                if ($smtp->hello('localhost')) {
                    if ($smtp->authenticate($this->username, $this->password)) {
                        return true;
                    } else {
                        $data = [$this->host, $this->port, $this->smtpSecure, $this->username];
                        throw new Exception('Authentication failed ('.implode(',', $data).'): '.$smtp->getLastReply() . PHP_EOL . print_r($smtp->getError(), true));
                    }
                } else {
                    throw new Exception('HELO failed: '.$smtp->getLastReply());
                }
            } else {
                throw new Exception('Connect failed');
            }
        } catch (Exception $e) {
            $smtp->quit(true);
            throw new \yii\base\Exception($e->getMessage());
        }
    }
}
