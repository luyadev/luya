<?php

namespace bootstrap4;

class ActiveForm extends \yii\widgets\ActiveForm
{
	public $fieldClass = 'bootstrap4\ActiveField';
	
	public $errorCssClass = 'has-danger';
	
	public $successCssClass = 'has-success';
}