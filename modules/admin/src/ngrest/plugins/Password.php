<?php

namespace admin\ngrest\plugins;

class Password extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-password', $id, $ngModel);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
