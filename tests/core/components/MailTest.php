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
        $this->assertInstanceOf('PHPMailer\PHPMailer\PHPMailer', $mail->getMailer());
    }
    
    public function testRealdSendMailError()
    {
        $mail = new Mail();
        $this->assertFalse($mail->compose('foobar', 'phpunit')->address('bug@luya.io')->send());
        $this->assertFalse(empty($mail->getError()));
    }
    
    public function testAddresses()
    {
        $mail = new Mail();
        $mail->address('mailonly@example.com');
        $mail->address('withname@example.com', 'John Doe');
        $mail->addresses([
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

    public function testCcAddresses()
    {
        $mail = new Mail();
        $mail->ccAddresses(['foo@bar.com', 'John Doe' => 'john.doe@notamail.com']);

        $mailerBcc = $mail->mailer->getCcAddresses();

        $this->assertSame('foo@bar.com', $mailerBcc[0][0]);
        $this->assertSame('foo@bar.com', $mailerBcc[0][1]);

        $this->assertSame('john.doe@notamail.com', $mailerBcc[1][0]);
        $this->assertSame('John Doe', $mailerBcc[1][1]);
    }

    public function testBccAddresses()
    {
        $mail = new Mail();
        $mail->bccAddresses(['foo@bar.com', 'John Doe' => 'john.doe@notamail.com']);

        $mailerBcc = $mail->mailer->getBccAddresses();

        $this->assertSame('foo@bar.com', $mailerBcc[0][0]);
        $this->assertSame('foo@bar.com', $mailerBcc[0][1]);

        $this->assertSame('john.doe@notamail.com', $mailerBcc[1][0]);
        $this->assertSame('John Doe', $mailerBcc[1][1]);
    }
    
    public function testLayoutWrapper()
    {
        $mail = new Mail();
        $mail->layout = '@app/views/maillayout.php';
        $mail->body('CONTENT');
        $this->assertEquals('<div>CONTENT</div>', $mail->mailer->Body);
    }
    
    public function testLayoutWithoutWrapper()
    {
        $mail = new Mail();
        $mail->layout = false;
        $mail->body('CONTENT');
        $this->assertEquals('CONTENT', $mail->mailer->Body);
    }
    
    public function testLayoutContextVars()
    {
        $mail = new Mail();
        $mail->layout = '@app/views/maillayout.php';
        $mail->context(['option' => 'Option Context']);
        $mail->body('CONTENT');
        $this->assertEquals('<div>CONTENT</div>Option Context', $mail->mailer->Body);
    }
    
    public function testChaining()
    {
        $mail = (new Mail())->compose()->subject('foobar')->body('barfoo')->mailer;
        
        $this->assertSame('foobar', $mail->Subject);
        $this->assertSame('barfoo', $mail->Body);
    }
    
    public function testEmptyChainException()
    {
        $this->expectException('luya\Exception');
        $mail = (new Mail())->compose()->send();
    }
    
    public function testReplyTo()
    {
        $mail = (new Mail())->addReplyTo('hello@luya.io', 'Name');
        
        $this->assertSame(['hello@luya.io' => [
            'hello@luya.io', 'Name'
        ]], $mail->mailer->getReplyToAddresses());
        
        $mail = (new Mail())->addReplyTo('hello@luya.io');
        
        $this->assertSame(['hello@luya.io' => [
            'hello@luya.io', 'hello@luya.io'
        ]], $mail->mailer->getReplyToAddresses());
    }
    
    public function testPhpmailerXMailer()
    {
        $mail = new Mail();
        $mailer = $mail->mailer;
        $header = $mailer->createHeader();
        $this->assertStringNotContainsString('X-Mailer', $header);
    }
    
    public function testAltBody()
    {
        $mail = new Mail();
        $mail->body('<html><head><title>Foo</title></head><body><h1>Foo</h1><p>Bar</p></body></html>');
        $this->assertEquals("Foo". PHP_EOL . "Bar", $mail->getMailer()->AltBody);
        
        $this->assertSame('Bar', $mail->convertMessageToAltBody('<p>Bar</p>'));
    }
    
    public function testAltBodySetBySetter()
    {
        $mail = new Mail();
        $mail->altBody = 'Alt Body!';
        $mail->compose('Subject', 'Content');
        $this->assertSame('Alt Body!', $mail->getMailer()->AltBody);
        
        $this->assertSame('Bar', $mail->convertMessageToAltBody('<p>Bar</p>'));
    }

    public function testAttachementPathInfo()
    {
        $mail = new Mail();
        $mail->compose('bar', 'foo');
        $file = Yii::getAlias('@app/hashfile.txt');
        $mail->addAttachment($file);
        
        $this->assertNotEmpty($mail->getMailer()->getAttachments());
    }
}
