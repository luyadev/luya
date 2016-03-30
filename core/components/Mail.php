<?php

namespace luya\components;

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
 * @author nadar
 */
class Mail extends \yii\base\Component
{
    private $_mailer = null;

    public $from = 'php@zephir.ch';

    public $fromName = 'php@zephir.ch';

    public $host = 'mail.zephir.ch';

    public $username = 'php@zephir.ch';

    public $password = null; // insert password

    public $isSMTP = true;

    public $altBody = 'Please use a HTML compatible E-Mail-Client to read this E-Mail.';

    public $port = 587;

    public $debug = false;
    
    /**
     * @var string Posible values are `tls` or `ssl`
     */
    public $smtpSecure = 'tls';
    
    /**
     * @todo Remove in beta7
     * @return NULL|\PHPMailer
     */
    public function mailer()
    {
        trigger_error("Deprecated function called: " . __METHOD__, E_USER_NOTICE);
        return $this->getMailer();
    }
    
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
     * Set the HTML body for the mailer message
     * 
     * @param string $body The HTML body message
     * @return \luya\components\Mail
     */
    public function setBody($body)
    {
        $this->getMailer()->Body = $body;
        return $this;
    }

    /**
     * Add multiple adresses into the mailer object.
     * 
     * If no key is used, the name is going to be ignore, if a string key is availabe it represents the name.
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
     * Add a single addresse with optional name
     * 
     * @param string $email The email adresse e.g john@example.com
     * @param string $name The name for the adresse e.g John Doe
     * @return \luya\components\Mail
     */
    public function address($email, $name = null)
    {
        $this->getMailer()->addAddress($email, (empty($name)) ? $email : $name);

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
