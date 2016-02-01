<?php

namespace frontendgroup;

use Yii;
use cms\menu\Container;
use yii\base\BootstrapInterface;
use admin\models\Property;
use cmsadmin\models\Property as CmsProperty;
use frontendgroup\properties\GroupAuthProperty;

/**
 * 
 * @author nadar
 */
class Module extends \luya\base\Module implements BootstrapInterface
{   
    protected $properties = [];
    
    public function bootstrap($app)
    {
        $findProperty = Property::findOne(['class_name' => GroupAuthProperty::className()]);
        
        if ($findProperty) {
            $this->properties = CmsProperty::findAll(['admin_prop_id' => $findProperty->id]);
            Yii::$app->menu->on(Container::MENU_ITEM_EVENT, [$this, 'hideElements']);
        }
        
    }

    public function hideElements($event)
    {
        foreach($this->properties as $prop) {
            if ($prop->object->requiresAuth() && $event->item->navId == $prop->nav_id) {
                $event->visible = false;
                foreach ($this->frontendUsers as $userComponent) {
                    $user = Yii::$app->get($userComponent);
                    if (!$user->isGuest && $user->inGroup($prop->object->getGroups())) {
                        $event->visible = true;
                    }
                }
            }
        }
    }
    
    /**
     * Define all available frontend groups
     *
     * @var array An array contain all frontend groups which are available, like
     *
     * ```php
     * $frontendGroups = ['patient', 'expert', 'those', 'theothers'];
     * ```
     */
    public $frontendGroups = [];
    
    /**
     * @var array Define an array with the names of defined yii\web\User's from the config. Example defintion
     * in the config. This array will be used to perform group permission checks based on the
     * luya\web\GroupUserIdentityInterface implemantions of `authGroups()`.
     *
     * ```
     * 'patient' => [
     *     'class' => 'luya\web\GroupUser',
     *     'identityClass' => 'app\models\frontend\Patient',
     * ],
     * 'expert' => [
     *     'class' => 'luya\web\GroupUser',
     *     'identityClass' => 'app\models\frontend\Expert',
     * ],
     * ```
     *
     * would look like this in frontendUsers array
     *
     * ```
     * $frontendUsers = ['patient', 'expert'];
     * ```
     *
     * You can define this property via the application configuration.
     */
    public $frontendUsers = [];
}