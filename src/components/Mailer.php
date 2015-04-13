<?php
namespace luya\components;

class Mailer extends \yii\base\Component
{
    public $phpmailer = null;

    public $isSMTP = null;

    public $host = null; //'mail.yourserver.com';

    public $username = null; //'php@yourserver.com';

    public $password = null; //'PASSWORD';

    public function create()
    {
        $this->phpmailer = new \PHPMailer();
        
        if ($this->host === null) {
            $this->host = \yii::$app->getModule('luya')->mailerHost;
        }
        
        if ($this->username === null) {
            $this->host = \yii::$app->getModule('luya')->mailerUsername;
        }
        
        if ($this->password === null) {
            $this->password = \yii::$app->getModule('luya')->mailerPassword;
        }
        
        if ($this->isSMTP === null) {
            $this->isSMTP = \yii::$app->getModule('luya')->mailerIsSMTP;
        }
        
        if ($this->isSMTP) {
            $this->phpmailer->SMTPDebug = 2;
            $this->phpmailer->isSMTP();
            $this->phpmailer->Host = $this->host;
            $this->phpmailer->Username = $this->username;
            $this->phpmailer->Password = $this->password;
            $this->phpmailer->Port = 587;
            $this->phpmailer->SMTPSecure = 'tls';
            $this->phpmailer->SMTPAuth = true;
        }
        $this->phpmailer->From = 'php@luya.io';
        $this->phpmailer->FromName = 'php@luya.io';
        $this->phpmailer->isHTML(true);
        $this->phpmailer->AltBody = 'Please use a HTML compatible E-Mail-Client to read this E-Mail.';
    }
    
    public function compose($subject, $body)
    {
        $this->cleanup();
        $this->create();
        $this->phpmailer->Subject = $subject;
        $this->phpmailer->Body = $body;

        return $this;
    }

    public function address($email, $name = null)
    {
        $this->phpmailer->addAddress($email, (empty($name)) ? $email : $name);

        return $this;
    }

    public function send()
    {
        return $this->phpmailer->send();
    }

    public function error()
    {
        return $this->phpmailer->ErrorInfo;
    }
    
    public function cleanup()
    {
        $this->phpmailer = null;
    }
}
