<?php

namespace admintests\data\fixtures;

use yii\test\ActiveFixture;

class TagFixture extends ActiveFixture
{
    public $modelClass = 'luya\admin\models\Tag';

    public function load()
    {
        parent::resetTable();
        parent::load();
    }
    
    public function getData()
    {
        return [
            'tag1' => [
                'id' => '1',
                'name' => 'john',
            ],
            'tag2' => [
                'id' => '2',
                'name' => 'Jane',
            ],
        ];
    }
}
