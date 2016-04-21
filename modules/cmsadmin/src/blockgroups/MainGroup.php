<?php

namespace cmsadmin\blockgroups;

use Yii;
use cmsadmin\base\BlockGroup;

class MainGroup extends BlockGroup
{
    public function identifier()
    {
        return 'main-group';
    }
    
    public function label()
    {
        return Yii::t('app', 'Basic Elements');
    }
}
