<?php

namespace cmsadmin\blocks;

use \cebe\markdown\GithubMarkdown;

class FormBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public $_parser = null;

    /**
     * @todo: show success message
     */
    public function sendMail()
    {
        $to = $this->getVarValue('emailAddress');
        $subject = $this->getVarValue('subjectText','Kontaktanfrage von').' '.$_POST['name'];
        $message = $_POST['message'];

        $headers =  'From: '.$_POST['email']. "\r\n".
                    'Reply-To: '.$_POST['email']."\r\n".
                    'X-Mailer: PHP/' . phpversion();

        mail($to,$subject,$message, $headers);
    }

    /**
     * @todo: check required fields! and leave error message
     */
    public function init()
    {
        parent::init();

        if(isset($_POST['message']) && isset($_POST['email']) && isset($_POST['name'])) {
            $this->sendMail();
        }

    }

    public function getParser()
    {
        if( $this->_parser === null) {
            $this->_parser = new GithubMarkdown();
        }

        return $this->_parser;
    }

    public function name()
    {
        return 'Formular';
    }

    public function icon()
    {
        return 'mdi-communication-email';
    }

    /**
     * @todo: add ids in cfgs to every field to intercept via javascript
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'headline', 'label' => 'Überschrift', 'type' => 'zaa-text'],
                ['var' => 'nameText', 'label' => 'Text für Feld "Name"', 'type' => 'zaa-text'],
                ['var' => 'emailText', 'label' => 'Text für Feld "Email"', 'type' => 'zaa-text'],
                ['var' => 'commentText', 'label' => 'Text für Feld "Comment', 'type' => 'zaa-text'],
                ['var' => 'submitText', 'label' => 'Text auf dem Absendebutton', 'type' => 'zaa-text'],

                ['var' => 'emailAddress', 'label' => 'Email wird an folgende Adresse gesendet', 'type' => 'zaa-text'],
            ],

            'cfgs' => [
                ['var' => 'subjectText', 'label' => 'Betreff in der Email', 'type' => 'zaa-text'],
            ]
        ];
    }

    public function extraVars()
    {
        return [
            'nameText' => $this->getVarValue('nameText','Name'),
            'emailText' => $this->getVarValue('emailText','Email'),
            'commentText' => $this->getVarValue('commentText','Nachricht'),
            'submitText' => $this->getVarValue('submitText','Absenden'),
        ];
    }

    /**
     * @todo: add prefix to encapsulate block ids
     */
    public function twigFrontend()
    {
        return  '{% if vars.emailAddress is not empty %}{% if vars.headline is not empty %}<h3>{{ vars.headline }}</h3>{% endif %}'.
                '<form id="contact_form" action="" method="POST" enctype="multipart/form-data">'.
	            '<div class="row">'.
                '<label for="name">{{ extras.nameText }}</label><br />'.
		        '<input id="name" class="input" name="name" type="text" value="" size="30" /><br />'.
	            '</div>'.
	            '<div class="row">'.
		        '<label for="email">{{ extras.emailText }}</label><br />'.
		        '<input id="email" class="input" name="email" type="text" value="" size="30" /><br />'.
	            '</div>'.
	            '<div class="row">'.
		        '<label for="message">{{ extras.commentText }}</label><br />'.
		        '<textarea id="message" class="input" name="message" rows="7" cols="30"></textarea><br />'.
	            '</div>'.
	            '<input id="submit_button" type="submit" value="{{ extras.submitText }}" />'.
                '</form>{% endif %}';
    }

    public function twigAdmin()
    {
        return  '{% if vars.emailAddress is not empty %}{% if vars.headline is not empty %}<h3>{{ vars.headline }}</h3>{% endif %}'.
                '<form id="contact_form" action="#" method="POST" enctype="multipart/form-data">'.
                '<div class="row">'.
                '<label for="name">{{ extras.nameText }}</label><br />'.
                '<input id="name" class="input" name="name" type="text" value="" size="30" /><br />'.
                '</div>'.
                '<div class="row">'.
                '<label for="email">{{ extras.emailText }}</label><br />'.
                '<input id="email" class="input" name="email" type="text" value="" size="30" /><br />'.
                '</div>'.
                '<div class="row">'.
                '<label for="message">{{ extras.commentText }}</label><br />'.
                '<textarea id="message" class="input" name="message" rows="7" cols="30"></textarea><br />'.
                '</div>'.
                '<input id="submit_button" type="submit" value="{{ extras.submitText }}" disabled/>'.
                '</form>{% else %}<span class="block__empty-text">Es wurde noch keine Emailadresse angegeben.</span>{% endif %}';
    }
}
