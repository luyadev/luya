<?php

namespace cms\menu;

use Iterator;
use Countable;

class QueryIterator extends \yii\base\Object implements Iterator, Countable
{
    public $data = [];

    public function count()
    {
        return count($this->data);
    }

    public function current()
    {
        return Query::createItemObject(current($this->data));
    }

    public function key()
    {
        return key($this->data);
    }

    public function next()
    {
        return next($this->data);
    }

    public function rewind()
    {
        return reset($this->data);
    }

    public function valid()
    {
        return key($this->data) !== null;
    }
}
