<?php

namespace luya\web;

use yii\base\Object;
use yii\validators\EmailValidator;

/**
 * Email Link.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class EmailLink extends Object implements LinkInterface
{
	use LinkTrait;
	
	private $_email;
	
	/**
	 * Setter method for E-Mail.
	 * 
	 * If the email is not valid, no value is set.
	 * 
	 * @param unknown $email
	 */
	public function setEmail($email)
	{
		$validator = new EmailValidator();
		if ($validator->validate($email)) {
			$this->_email = $email;
		}
	}
	
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