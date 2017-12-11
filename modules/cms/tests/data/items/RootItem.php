<?php

namespace cmstests\data\items;

use luya\cms\menu\InjectItemInterface;

class RootItem implements InjectItemInterface
{
    public function getLang()
    {
        return 'de';
    }
    
    public function getId()
    {
        return 1;
    }
    
    public function toArray()
    {
        return [
                'id' => $this->getId(),
                'nav_id' => 1,
                'lang' => $this->getLang(),
                'link' => '/',
                'title' => 'Root',
                'title_tag' => 'Root',
                'alias' => 'root',
                'description' => null,
                'keywords' => null,
                'create_user_id' => 0,
                'update_user_id' => 0,
                'timestamp_create' => time(),
                'timestamp_update' => time(),
                'is_home' => 1,
                'parent_nav_id' => 0,
                'sort_index' => 0,
                'is_hidden' => false,
                'type' => 1,
                'redirect' => false,
                'container' => 'default',
                'depth' => 0,
        ];
    }
}
