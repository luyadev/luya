<?php

namespace luya\components;

use Exception;
use PHPMailer;
use SMTP;

/**
 * smtp debug
 * 
 * ```
 * swaks -s HOST -p 587 -ehlo localhost -au AUTH_USER -to TO_ADRESSE -tls
 * ```
 * 
 * @author nadar
 */
class Mail extends \yii\base\Component
{
    private $_phpmailer = null;

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
    
    public function mailer()
    {
        if ($this->_phpmailer === null) {
            $this->_phpmailer = new PHPMailer();
            $this->_phpmailer->CharSet = 'UTF-8';
        }

        return $this->_phpmailer;
    }

    public function create()
    {
        if ($this->isSMTP) {
            if ($this->debug) {
                $this->mailer()->SMTPDebug = 2;
            }
            $this->mailer()->isSMTP();
            $this->mailer()->SMTPSecure = $this->smtpSecure;
            $this->mailer()->Host = $this->host;
            $this->mailer()->SMTPAuth = true;
            $this->mailer()->Username = $this->username;
            $this->mailer()->Password = $this->password;
            $this->mailer()->Port = $this->port;
            $this->mailer()->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ),
            );
        }
        $this->mailer()->From = $this->from;
        $this->mailer()->FromName = $this->fromName;
        $this->mailer()->isHTML(true);
        $this->mailer()->AltBody = $this->altBody;
    }

    public function compose($subject, $body)
    {
        $this->cleanup();
        $this->create();
        $this->mailer()->Subject = $subject;
        $this->mailer()->Body = $body;

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
     * @return void
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
    
    public function address($email, $name = null)
    {
        $this->mailer()->addAddress($email, (empty($name)) ? $email : $name);

        return $this;
    }

    public function send()
    {
        return $this->mailer()->send();
    }

    public function error()
    {
        return $this->mailer()->ErrorInfo;
    }

    public function cleanup()
    {
        $this->_phpmailer = null;
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
            //Connect to an SMTP server
            if ($smtp->connect($this->host, $this->port)) {
                //Say hello
                if ($smtp->hello('localhost')) { //Put your host name in here
                    //Authenticate
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
