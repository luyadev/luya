<?php

namespace luyatests\core\components;

use Yii;
use luya\components\Mail;

/**
 * @author nadar
 */
class MailTest extends \luyatests\LuyaWebTestCase
{
    public function testAppMailerObject()
    {
        $this->assertTrue(Yii::$app->mail instanceof \luya\components\Mail);
    }
    
    public function testMailerObject()
    {
        $mail = new Mail();
        $this->assertInstanceOf('PHPMailer', $mail->getMailer());
    }
    
    public function testRealdSendMailError()
    {
        $mail = new Mail();
        $this->assertFalse($mail->compose('foobar', 'phpunit')->address('bug@luya.io')->send());
        $this->assertFalse(empty($mail->getError()));
    }
    
    public function testAdresses()
    {
        $mail = new Mail();
        $mail->address('mailonly@example.com');
        $mail->address('withname@example.com', 'John Doe');
        $mail->adresses([
            'arraymailonly@example.com',
            'Jane Doe' => 'arraywithname@example.com'
        ]);
        
        $mailerTo = $mail->mailer->getToAddresses();
        
        $this->assertSame('mailonly@example.com', $mailerTo[0][0]);
        $this->assertSame('mailonly@example.com', $mailerTo[0][1]);
        
        $this->assertSame('withname@example.com', $mailerTo[1][0]);
        $this->assertSame('John Doe', $mailerTo[1][1]);
        
        $this->assertSame('arraymailonly@example.com', $mailerTo[2][0]);
        $this->assertSame('arraymailonly@example.com', $mailerTo[2][1]);
        
        $this->assertSame('arraywithname@example.com', $mailerTo[3][0]);
        $this->assertSame('Jane Doe', $mailerTo[3][1]);
    }
    
    public function testLayoutWrapper()
    {
        $mail = new Mail();
        $mail->layout = '@app/views/maillayout.php';
        $mail->setBody('CONTENT');
        $this->assertEquals('<div>CONTENT</div>', $mail->mailer->Body);
    }
    
    public function testLayoutWithoutWrapper()
    {
        $mail = new Mail();
        $mail->layout = false;
        $mail->setBody('CONTENT');
        $this->assertEquals('CONTENT', $mail->mailer->Body);
    }
}
