<?php
namespace luya\components;

class Mailer extends \yii\base\Component
{
    public $phpmailer = null;
    
    public $isSMTP = true;
    
    public $host = 'mail.yourserver.com';
    
    public $username = 'php@yourserver.com';
    
    public $password = 'PASSWORD';
    
    public function init()
    {
        $this->phpmailer = new \PHPMailer();
        
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
    
}