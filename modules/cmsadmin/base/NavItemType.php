<?php
namespace cmsadmin\base;

abstract class NavItemType extends \yii\db\ActiveRecord
{
    abstract public function getContent();

    abstract public function getHeaders();
}
