<?php

namespace luya\components;

use Yii;
use yii\base\Component;
use luya\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * LUYA mail component to compose messages and send them via SMTP.
 *
 * This component is registered on each LUYA instance, how to use:
 *
 * ```php
 * if (Yii::$app->mail->compose('Subject', 'Message body of the Mail')->address('info@example.com')->send()) {
 *     echo "Mail has been sent!";
 * } else {
 *     echo "Error" : Yii::$app->mail->error;
 * }
 * ```
 *
 * SMTP debug help:
 *
 * ```
 * swaks -s HOST -p 587 -ehlo localhost -au AUTH_USER -to TO_ADDRESSE -tls
 * ```
 *
 * @property \PHPMailer\PHPMailer\PHPMailer $mailer The PHP Mailer object
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Mail extends Component
{
    private $_mailer;

    /**
     * @var string sender email address, like `php@luya.io`.
     */
    public $from;

    /**
     * @var string The from sender name like `LUYA Mailer`.
     */
    public $fromName;

    /**
     * @var boolean When enabled the debug print is echoed directly into the frontend output, this is built in PHPMailer debug.
     */
    public $debug = false;

    /**
     * @var string alternate text message if email client doesn't support HTML
     */
    public $altBody;
    
    /**
     * @var string|boolean Define a layout template file which is going to be wrapped around the body()
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
     * @var boolean Whether mailer sends mails trough an an smtp server or via php mail() function. In order to configure the smtp use:
     *
     * + {{Mail::$username}}
     * + {{Mail::$password}}
     * + {{Mail::$host}}
     * + {{Mail::$port}}
     * + {{Mail::$smtpSecure}}
     * + {{Mail::$smtpAuth}}
     */
    public $isSMTP = true;

    // smtp settings
    
    /**
     * @var string The host address of the SMTP server for authentification like `mail.luya.io`, if {{Mail::$isSMTP}} is disabled, this property has no effect.
     */
    public $host;
    
    /**
     * @var string The username which should be used for SMTP auth e.g `php@luya.io`, if {{Mail::$isSMTP}} is disabled, this property has no effect.
     */
    public $username;
    
    /**
     * @var string The password which should be used for SMTP auth, if {{Mail::$isSMTP}} is disabled, this property has no effect.
     */
    public $password;
    
    /**
     * @var integer The port which is used to connect to the SMTP server (default is 587), if {{Mail::$isSMTP}} is disabled, this property has no effect.
     */
    public $port = 587;
    
    /**
     * @var string Posible values are `tls` or `ssl` or empty `` (default is tls), if {{Mail::$isSMTP}} is disabled, this property has no effect.
     */
    public $smtpSecure = 'tls';
    
    /**
     * @var boolean Whether the SMTP requires authentication or not, enabled by default. If {{Mail::$isSMTP}} is disabled, this property has no effect. If
     * enabled the following properties can be used:
     * + {{Mail::$username}}
     * + {{Mail::$password}}
     */
    public $smtpAuth = true;
    
    /**
     * Getter for the mailer object
     *
     * @return \PHPMailer\PHPMailer\PHPMailer
     */
    public function getMailer()
    {
        if ($this->_mailer === null) {
            $this->_mailer = new PHPMailer();
            $this->_mailer->CharSet = 'UTF-8';
            $this->_mailer->From = $this->from;
            $this->_mailer->FromName = $this->fromName;
            $this->_mailer->isHTML(true);
            $this->_mailer->XMailer = ' ';
            // if sending over smtp, define the settings for the smpt server
            if ($this->isSMTP) {
                if ($this->debug) {
                    $this->_mailer->SMTPDebug = 2;
                }
                $this->_mailer->isSMTP();
                $this->_mailer->SMTPSecure = $this->smtpSecure;
                $this->_mailer->Host = $this->host;
                $this->_mailer->SMTPAuth= $this->smtpAuth;
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
     * Compose a new mail message.
     *
     * Make sure to change mailer object or global variables after composer command, as before it will flush the mailer object.
     *
     * @param string $subject The subject of the mail
     * @param string $body The HTML body of the mail message.
     * @return \luya\components\Mail
     */
    public function compose($subject = null, $body = null)
    {
        $this->cleanup();
        if ($subject !== null) {
            $this->subject($subject);
        }
        if ($body !== null) {
            $this->body($body);
        }
        return $this;
    }
    
    /**
     * Set the mail message subject of the mailer instance
     *
     * @param string $subject The subject message
     * @return \luya\components\Mail
     */
    public function subject($subject)
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
    public function body($body)
    {
        $message = $this->wrapLayout($body);
        $this->getMailer()->Body = $message;
        if (empty($this->altBody)) {
            $this->altBody = $this->convertMessageToAltBody($message);
        }
        $this->getMailer()->AltBody = $this->altBody;
        return $this;
    }

    /**
     * Try to convert the message into an alt body tag.
     *
     * The alt body can only contain chars and newline. Therefore strip all tags and replace ending tags with newlines.
     * Also remove html head if there is any.
     *
     * @param string $message The message to convert into alt body format.
     * @return string Returns the alt body message compatible content
     * @since 1.0.11
     */
    public function convertMessageToAltBody($message)
    {
        $message = preg_replace('/<head>(.*?)<\/head>/s', '', $message);
        $tags = ['</p>', '<br />', '<br>', '<hr />', '<hr>', '</h1>', '</h2>', '</h3>', '</h4>', '</h5>', '</h6>'];
        return trim(strip_tags(str_replace($tags, PHP_EOL, $message)));
    }
    
    /**
     * Render a view file for the given Controller context.
     *
     * Assuming the following example inside a controller:
     *
     * ```php
     * Yii::$app->mail->compose('Send E-Mail')->render('@app/views/_mail', ['foo' => 'bar'])->address('info@luya.io')->send();
     * ```
     *
     * @param string $viewFile The view file to render
     * @param array $params The parameters to pass to the view file.
     * @return \luya\components\Mail
     */
    public function render($viewFile, array $params = [])
    {
        $this->body(Yii::$app->view->render($viewFile, $params));
        
        return $this;
    }
    
    private $_context = [];
    
    /**
     * Pass option parameters to the layout files.
     *
     * @param array $vars
     * @return \luya\components\Mail
     */
    public function context(array $vars)
    {
        $this->_context = $vars;
        
        return $this;
    }

    /**
     * Wrap the layout from the `$layout` propertie and store
     * the passed  content as $content variable in the view.
     *
     * @param string $content The content to wrapp inside the layout.
     * @return string
     */
    protected function wrapLayout($content)
    {
        // do not wrap the content if layout is turned off.
        if ($this->layout === false) {
            return $content;
        }
        
        $view = Yii::$app->getView();
        
        $vars = array_merge($this->_context, ['content' => $content]);
        
        return $view->renderPhpFile(Yii::getAlias($this->layout), $vars);
    }
    
    /**
     * Add multiple addresses into the mailer object.
     *
     * If no key is used, the name is going to be ignored, if a string key is available it represents the name.
     *
     * ```php
     * addresses(['foo@example.com', 'bar@example.com']);
     * ```
     *
     * or with names
     *
     * ```php
     * addresses(['John Doe' => 'john.doe@example.com', 'Jane Doe' => 'jane.doe@example.com']);
     * ```
     *
     * @return \luya\components\Mail
     * @param array $emails An array with email addresses or name => email paring to use names.
     */
    public function addresses(array $emails)
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
     * Add attachment.
     *
     * @param string $filePath The path to the file, will be checked with `is_file`.
     * @param string $name An optional name to use for the Attachment.
     * @return \luya\components\Mail
     */
    public function addAttachment($filePath, $name = null)
    {
        $this->getMailer()->addAttachment($filePath, empty($name) ? '' : $name);
        
        return $this;
    }
    
    /**
     * Add ReplyTo Address.
     *
     * @param string $email
     * @param string $name
     * @return \luya\components\Mail
     */
    public function addReplyTo($email, $name = null)
    {
        $this->getMailer()->addReplyTo($email, empty($name) ? $email : $name);
        
        return $this;
    }

    /**
     * Trigger the send event of the mailer
     * @return bool
     * @throws Exception
     */
    public function send()
    {
        if (empty($this->mailer->Subject) || empty($this->mailer->Body)) {
            throw new Exception("Mail subject() and body() can not be empty in order to send mail.");
        }
        if (!$this->getMailer()->send()) {
            Yii::error($this->getError(), __METHOD__);
            return false;
        }
        return true;
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
     * Test connection for smtp.
     *
     * @see https://github.com/PHPMailer/PHPMailer/blob/master/examples/smtp_check.phps
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
        } catch (\Exception $e) {
            $smtp->quit(true);
            throw new \yii\base\Exception($e->getMessage());
        }
    }
}
