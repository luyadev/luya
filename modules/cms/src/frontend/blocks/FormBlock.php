<?php

namespace luya\cms\frontend\blocks;

use Yii;
use yii\helpers\Html;
use luya\helpers\Url;
use luya\cms\frontend\Module;
use luya\cms\base\PhpBlock;

/**
 *
 * @author Basil Suter <basil@nadar.io>
 *
 */
final class FormBlock extends PhpBlock
{
    public $module = 'cms';

    public $defaultNameLabel = 'Name';
    
    public $defaultNamePlaceholder = 'Vor- und Nachname';
    
    public $defaultNameError = 'Bitte geben Sie einen Namen ein';

    public $defaultEmailLabel = 'Email';
    
    public $defaultEmailPlaceholder = 'beispiel@beispiel.ch';
    
    public $defaultEmailError = 'Bitte geben Sie eine Emailadresse ein';

    public $defaultMessageLabel = 'Nachricht';
    
    public $defaultMessageError = 'Bitte geben Sie eine Nachricht ein';

    public $defaultSendLabel = 'Absenden';

    public $defaultSendError = 'Leider ist ein Fehler beim Senden der Nachricht aufgetreten.';

    public $defaultSendSuccess = 'Vielen Dank! Wir werden uns mit Ihnen in Verbindung setzen.';

    public $defaultMailSubject = 'Kontaktanfrage';

    public function name()
    {
        return Module::t("block_form_name");
    }

    public function icon()
    {
        return 'email';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'emailAddress', 'label' => 'Email wird an folgende Adresse gesendet', 'type' => 'zaa-text'],
                ['var' => 'headline', 'label' => 'Überschrift', 'type' => 'zaa-text', 'placeholder' => 'Kontakt'],
                ['var' => 'nameLabel', 'label' => 'Text für Feld "Name"', 'type' => 'zaa-text', 'placeholder' => $this->defaultNameLabel],
                ['var' => 'emailLabel', 'label' => 'Text für Feld "Email"', 'type' => 'zaa-text', 'placeholder' => $this->defaultEmailLabel],
                ['var' => 'messageLabel', 'label' => 'Text für Feld "Nachricht"', 'type' => 'zaa-text', 'placeholder' => $this->defaultMessageLabel],
                ['var' => 'sendLabel', 'label' => 'Text auf dem Absendebutton', 'type' => 'zaa-text', 'placeholder' => $this->defaultSendLabel],
            ],

            'cfgs' => [
                ['var' => 'subjectText', 'label' => 'Betreff in der Email', 'type' => 'zaa-text', 'placeholder' => $this->defaultMailSubject],
                ['var' => 'namePlaceholder', 'label' => 'Platzhalter im Feld "Name"', 'type' => 'zaa-text', 'placeholder' => $this->defaultNamePlaceholder],
                ['var' => 'emailPlaceholder', 'label' => 'Platzhalter im Feld "Email"', 'type' => 'zaa-text', 'placeholder' => $this->defaultEmailPlaceholder],
                ['var' => 'nameError', 'label' => 'Fehlermeldung für Feld "Name"', 'type' => 'zaa-text', 'placeholder' => $this->defaultNameError],
                ['var' => 'emailError', 'label' => 'Fehlermeldung für Feld "Email"', 'type' => 'zaa-text', 'placeholder' => $this->defaultEmailError],
                ['var' => 'messageError', 'label' => 'Fehlermeldung für Feld "Nachricht"', 'type' => 'zaa-text', 'placeholder' => $this->defaultMessageError],
                ['var' => 'sendSuccess', 'label' => 'Bestätigungstext nach Absenden des Formulars', 'type' => 'zaa-text', 'placeholder' => $this->defaultSendSuccess],
                ['var' => 'sendError', 'label' => 'Fehlertext nach fehlgeschlagenem Sendeversuch des Formulars', 'type' => 'zaa-text', 'placeholder' => $this->defaultSendError],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'nameLabel' => $this->getVarValue('nameLabel', $this->defaultNameLabel),
            'namePlaceholder' => $this->getCfgValue('namePlaceholder', $this->defaultNamePlaceholder),
            'nameError' => $this->getCfgValue('nameError', $this->defaultNameError),
            'emailLabel' => $this->getVarValue('emailLabel', $this->defaultEmailLabel),
            'emailPlaceholder' => $this->getCfgValue('emailPlaceholder', $this->defaultEmailPlaceholder),
            'emailError' => $this->getCfgValue('emailError', $this->defaultEmailError),
            'messageLabel' => $this->getVarValue('messageLabel', $this->defaultMessageLabel),
            'messageError' => $this->getCfgValue('messageError', $this->defaultMessageError),
            'sendLabel' => $this->getVarValue('sendLabel', $this->defaultSendLabel),
            'sendError' => $this->getCfgValue('sendError', $this->defaultSendError),
            'sendSuccess' => $this->getCfgValue('sendSuccess', $this->defaultSendSuccess),
            'subjectText' => $this->getCfgValue('subjectText', $this->defaultMailSubject),
            'message' => Yii::$app->request->post('message'),
            'name' => Yii::$app->request->post('name'),
            'email' => Yii::$app->request->post('email'),
            'mailerResponse' => $this->getPostResponse(),
            'csrf' => Yii::$app->request->csrfToken,
            'nameErrorFlag' => Yii::$app->request->isPost ? (Yii::$app->request->post('name') ? 1 : 0): 1,
            'emailErrorFlag' => Yii::$app->request->isPost ? (Yii::$app->request->post('email') ? 1 : 0): 1,
            'messageErrorFlag' => Yii::$app->request->isPost ? (Yii::$app->request->post('message') ? 1 : 0): 1,
        ];
    }

    public function sendMail($message, $email, $name)
    {
        $email = Html::encode($email);
        $name = Html::encode($name);
        
        $html = "<p>You have recieved an E-Mail via Form Block on " . Url::base(true)."</p>";
        $html.= "<p>From: " . $name." ($email)<br />Time:".date("d.m.Y - H:i"). "<br />";
        $html.= "Message:<br />" . nl2br(Html::encode($message)) ."</p>";
        
        $mail = Yii::$app->mail;
        $mail->fromName = $name;
        $mail->from = $email;
        $mail->compose($this->getVarValue('subjectText', $this->defaultMailSubject), $html);
        $mail->address($this->getVarValue('emailAddress'));

        if (!$mail->send()) {
            return 'Error: '.$mail->error;
        } else {
            return 'success';
        }
    }

    public function getPostResponse()
    {
        $request = Yii::$app->request;

        if (Yii::$app->request->isPost) {
            if ($request->post('message') && $request->post('email') && $request->post('name')) {
                return $this->sendMail($request->post('message'), $request->post('email'), $request->post('name'));
            }
        }
    }
    
    public function admin()
    {
        return  '<p><i>Form Block</i></p>{% if vars.emailAddress is not empty %}'.
                    '{% if vars.headline is not empty %}<h3>{{ vars.headline }}</h3>{% endif %}'.
                        '<div class="input input--text">'.
                            '<label for="name" class="input__label">{{ extras.nameLabel }}</label>'.
                            '<div class="input__field-wrapper"><input id="name" class="input__field" disabled="disabled" /></div>'.
                        '</div>'.
                        '<div class="input input--text">'.
                        '<label for="name" class="input__label">{{ extras.emailLabel }}</label>'.
                        '<div class="input__field-wrapper"><input id="name" class="input__field" disabled="disabled" /></div>'.
                        '</div>'.
                        '<div class="input input--text">'.
                        '<label for="name" class="input__label">{{ extras.messageLabel }}</label>'.
                        '<div class="input__field-wrapper"><textarea class="input__field" disabled="disabled" /></div>'.
                        '</div>'.
                        '<button class="btn" disabled>{{ extras.sendLabel }}</button>'.
                    '{% else %}<span class="block__empty-text">Es wurde noch keine Emailadresse angegeben.</span>'.
                '{% endif %}';
    }
}
