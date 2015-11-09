<?php

namespace account\properties;

use Yii;
use luya\helpers\Url;

class IsProtectedAreaProperty extends \admin\base\Property
{
    public function init()
    {
        $this->on(self::EVENT_BEFORE_RENDER, [$this, 'eventBeforeRender']);
    }

    public function eventBeforeRender($event)
    {
        if ($this->value === 1) {
            if (Yii::$app->getModule('account')->getUserIdentity()->isGuest) {
                $event->isValid = false;
                Yii::$app->response->redirect(Url::toManager('account/default/index'));
            }
        }
    }

    public function varName()
    {
        return 'isProtectedArea';
    }

    public function label()
    {
        return 'Diese Seite schützen';
    }

    public function type()
    {
        return 'zaa-select';
    }

    public function options()
    {
        return [
            ['value' => 0, 'label' => 'Nein'],
            ['value' => 1, 'label' => 'Ja'],
        ];
    }
}
