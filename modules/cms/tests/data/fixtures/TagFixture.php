<?php

namespace cmstests\data\fixtures;

use yii\test\ActiveFixture;

class TagFixture extends ActiveFixture
{
    public $modelClass = 'luya\admin\models\Tag';

    public function getData()
    {
        return [
            'tag1' => [
                'id' => '1',
                'name' => 'John',
            ],
            'tag2' => [
                'id' => '2',
                'name' => 'Jane',
            ],
        ];
    }
}
