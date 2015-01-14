<?php
namespace admin\straps;

use luya\ngrest\StrapAbstract;
use luya\ngrest\StrapInterface;

class Delete extends StrapAbstract implements StrapInterface
{
    public function render()
    {
        return 'hi_world';
    }
}
