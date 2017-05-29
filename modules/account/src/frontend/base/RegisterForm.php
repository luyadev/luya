<?php

namespace luya\account\frontend\base;

use Yii;
use luya\account\RegisterInterface;

abstract class RegisterForm extends \yii\base\Model implements RegisterInterface
{
    private $_model;
    
    protected $modelClass = 'luya\account\models\User';
    
    protected $modelScenario = 'register';
    
    public $firstname;
    
    public $lastname;
    
    public $gender;
    
    public $street;
    
    public $email;
    
    public $password;
    
    public $password_confirm;
    
    public $zip;
    
    public $city;
    
    public $company;
    
    public $country;
    
    public $subscription_newsletter = 0;
    
    public $subscription_medianews = 0;
    
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'gender', 'street', 'email', 'password', 'password_confirm', 'zip', 'city', 'company', 'country'], 'required'],
            [['subscription_medianews', 'subscription_newsletter'], 'safe'],
        ];
    }
    
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject(['class' => $this->modelClass]);
        }
    
        return $this->_model;
    }
    
    public function register()
    {
        if ($this->validate()) {
            $model = $this->model;
            $model->scenario = $this->modelScenario;
            $model->attributes  = $this->attributes;
            //$model->setAttributes($this->getAttributes());
            if ($model->validate()) {
                if ($model->save()) {
                    return $model;
                }
            } else {
                $this->addErrors($model->getErrors());
            }
        }
    
        return false;
    }
}
