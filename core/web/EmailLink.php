<?php

namespace luya\web;

use yii\base\InvalidConfigException;
use yii\validators\EmailValidator;

/**
 * Email Link.
 *
 * Represent a {{luya\web\LinkInterface}} of an e-mail mailto link.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class EmailLink extends BaseLink
{
    private $_email;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->email === null) {
            throw new InvalidConfigException('The email attribute can not be empty and must be set trough configuration array.');
        }
    }

    /**
     * Setter method for e-mail.
     *
     * If no valid email is provided, not value is set.
     *
     * @param string $email The e-mail which should be used for the mailto link.
     */
    public function setEmail($email)
    {
        $validator = new EmailValidator();
        if ($validator->validate($email)) {
            $this->_email = $email;
        } else {
            $this->_email = false;
        }
    }

    /**
     * Getter method for the e-mail.
     *
     * @return string|boolean Returns the e-mail from the setter method, if mail is not valid false is returned.
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @inheritdoc
     */
    public function getHref()
    {
        return empty($this->getEmail()) ? null : 'mailto:' . $this->getEmail();
    }

    /**
     * @inheritdoc
     */
    public function getTarget()
    {
        return '_blank';
    }
}
