<?php

namespace luya\components;

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
    
    public $port = '587';
    
    public function create()
    {
        $this->_phpmailer = new \PHPMailer();
        $this->_phpmailer->do_debug = 0;
        if ($this->isSMTP) {
            $this->_phpmailer->SMTPDebug = false;
            $this->_phpmailer->isSMTP();
            $this->_phpmailer->SMTPSecure = 'tls';
            $this->_phpmailer->Host = $this->host;
            $this->_phpmailer->SMTPAuth = true;
            $this->_phpmailer->Username = $this->username;
            $this->_phpmailer->Password = $this->password;
            $this->_phpmailer->Port = $this->port;
            $this->_phpmailer->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        }
        $this->_phpmailer->From = $this->from;
        $this->_phpmailer->FromName = $this->fromName;
        $this->_phpmailer->isHTML(true);
        $this->_phpmailer->AltBody = $this->altBody;
    }

    public function compose($subject, $body)
    {
        $this->cleanup();
        $this->create();
        $this->_phpmailer->Subject = $subject;
        $this->_phpmailer->Body = $body;
        return $this;
    }

    public function address($email, $name = null)
    {
        $this->_phpmailer->addAddress($email, (empty($name)) ? $email : $name);

        return $this;
    }

    public function send()
    {
        return $this->_phpmailer->send();
    }

    public function error()
    {
        return $this->_phpmailer->ErrorInfo;
    }

    public function cleanup()
    {
        $this->_phpmailer = null;
    }
}
