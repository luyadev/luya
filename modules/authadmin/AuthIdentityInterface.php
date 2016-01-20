<?php

namespace authadmin;

interface AuthUserInterface extends \yii\web\IdentityInterface
{
	public function authGroups();
}