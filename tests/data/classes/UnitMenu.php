<?php

namespace luyatests\data\classes;

use yii\base\Component;

class UnitMenu extends Component
{
    public $fakeError = false;

    public $fakeType2 = false;

    public function find()
    {
        return $this;
    }

    public function where($def)
    {
        if (is_array($def)) {
            if ($def['id'] == 1) {
                $this->fakeError = true;
            } elseif ($def['id'] == 2) {
                $this->fakeType2 = true;
            }
        }
        return $this;
    }

    public function with()
    {
        return $this;
    }

    public function lang()
    {
        return $this;
    }

    public $getHome = false;

    public function one()
    {
        if ($this->fakeError) {
            return false;
        }

        if ($this->fakeType2) {
            return new ItemModule();
        }

        if ($this->getHome) {
            return new ItemHome();
        }

        return new Item();
    }
}

class Item
{
    public $type = 1;

    public $link = 'this-is-a-cms-link';

    public $isHome = false;
}

class ItemHome
{
    public $type = 1;

    public $link = 'this-is-a-cms-link';

    public $isHome = true;
}

class ItemModule
{
    public $type = 2;

    public $link = 'this-is-a-module-type-page';

    public $moduleName = 'unitmodule';

    public $isHome = false;
}
