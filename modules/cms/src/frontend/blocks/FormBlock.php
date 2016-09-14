<?php

namespace luya\cms\frontend\blocks;

use Yii;
use yii\helpers\Html;
use luya\helpers\Url;
use luya\cms\base\TwigBlock;
use luya\cms\frontend\Module;

/**
 * 
 * @author Basil Suter <basil@nadar.io>
 *
 */
class FormBlock extends TwigBlock
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
                ['var' => 'headline', 'label' => 'Überschrift', 'type' => 'zaa-text', 'placeholder' => 'Kontakt'],
                ['var' => 'nameLabel', 'label' => 'Text für Feld "Name"', 'type' => 'zaa-text', 'placeholder' => $this->defaultNameLabel],
                ['var' => 'emailLabel', 'label' => 'Text für Feld "Email"', 'type' => 'zaa-text', 'placeholder' => $this->defaultEmailLabel],
                ['var' => 'messageLabel', 'label' => 'Text für Feld "Nachricht"', 'type' => 'zaa-text', 'placeholder' => $this->defaultMessageLabel],
                ['var' => 'sendLabel', 'label' => 'Text auf dem Absendebutton', 'type' => 'zaa-text', 'placeholder' => $this->defaultSendLabel],
                ['var' => 'emailAddress', 'label' => 'Email wird an folgende Adresse gesendet', 'type' => 'zaa-text'],
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

    /**
     * @todo: add prefix to encapsulate block ids
     */
    public function twigFrontend()
    {
        return  '{% if vars.emailAddress is not empty %}{% if vars.headline is not empty %}<h3>{{ vars.headline }}</h3>{% endif %}'.
                    '{% if extras.name and extras.email and extras.message %}'.
                        '{% if extras.mailerResponse == "success" %}'.
                            '<div class="alert alert-success">{{ extras.sendSuccess }}</div>'.
                         '{% else %}'.
                            '<div class="alert alert-danger">{{ extras.sendError }}</div>'.
                        '{% endif %}'.
                    '{% endif %}'.
                    '<form class="form-horizontal" role="form" method="post" action="">'.
                        '<input type="hidden" name="_csrf" value="{{extras.csrf}}" />'.
                        '<div class="form-group">'.
                            '<label for="name" class="col-sm-2 control-label">{{ extras.nameLabel }}</label>'.
                            '<div class="col-sm-10">'.
                                '<input type="text" class="form-control" id="name" name="name" placeholder="{{ extras.namePlaceholder }}" value="{% if extras.mailerResponse != "success" %}{{ extras.name }}{% endif %}">'.
                                '{% if not extras.nameErrorFlag%}<p class="text-danger">{{ extras.nameError }}</p>{% endif %}'.
                            '</div>'.
                        '</div>'.
                        '<div class="form-group">'.
                            '<label for="email" class="col-sm-2 control-label">{{ extras.emailLabel }}</label>'.
                            '<div class="col-sm-10">'.
                                '<input type="email" class="form-control" id="email" name="email" placeholder="{{ extras.emailPlaceholder }}" value="{% if extras.mailerResponse != "success" %}{{ extras.email }}{% endif %}">'.
                                '{% if not extras.emailErrorFlag %}<p class="text-danger">{{ extras.emailError }}</p>{% endif %}'.
                            '</div>'.
                        '</div>'.
                        '<div class="form-group">'.
                            '<label for="message" class="col-sm-2 control-label">{{ extras.messageLabel }}</label>'.
                            '<div class="col-sm-10">'.
                                '<textarea class="form-control" rows="4" name="message">{% if extras.mailerResponse != "success" %}{{ extras.message }}{% endif %}</textarea>'.
                                '{% if not extras.messageErrorFlag %}<p class="text-danger">{{ extras.messageError }}</p>{% endif %}'.
                            '</div>'.
                        '</div>'.
                        '<div class="form-group">'.
                            '<div class="col-sm-10 col-sm-offset-2">'.
                                '<input id="submit" name="submit" type="submit" value="{{ extras.sendLabel }}" class="btn btn-primary">'.
                            '</div>'.
                        '</div>'.
                    '</form>'.
                    '{% endif %}';
    }

    public function twigAdmin()
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
