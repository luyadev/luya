<?php

namespace luya\account\frontend\properties;

use Yii;
use luya\cms\helpers\Url;
use luya\admin\base\Property;

class IsProtectedAreaProperty extends Property
{
    public function init()
    {
        $this->on(self::EVENT_BEFORE_RENDER, [$this, 'eventBeforeRender']);
    }

    public function eventBeforeRender($event)
    {
        if ($this->value == 1) {
            if (Yii::$app->getModule('account')->getUserIdentity()->isGuest) {
                $event->isValid = false;
                return Yii::$app->response->redirect(Url::toModuleRoute('account', 'account/default/index', ['ref' => Yii::$app->request->url]));
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
