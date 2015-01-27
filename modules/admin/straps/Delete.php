<?php
namespace admin\straps;

use admin\ngrest\StrapAbstract;
use admin\ngrest\StrapInterface;

class Delete extends StrapAbstract implements StrapInterface
{
    public function render()
    {
        return 'hi_world';
    }
}
