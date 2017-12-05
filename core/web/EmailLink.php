<?php

namespace luya\web;

use yii\validators\EmailValidator;
use yii\base\BaseObject;

/**
 * Email Link.
 *
 * Represent a {{luya\web\LinkInterface}} of an e-mail mailto link.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class EmailLink extends BaseObject implements LinkInterface
{
    use LinkTrait;
    
    private $_email;
    
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
        }
    }
    
    /**
     * Getter method for the e-mail.
     *
     * @return string Returns the e-mail from the setter method, if mail is not valid null is returned.
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
        return empty($this->getEmail()) ?: 'mailto:' . $this->getEmail();
    }

    /**
     * @inheritdoc
     */
    public function getTarget()
    {
        return '_blank';
    }
}
