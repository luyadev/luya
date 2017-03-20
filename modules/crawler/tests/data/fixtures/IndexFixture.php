<?php

namespace crawlerests\data\fixtures;

use yii\test\ActiveFixture;

class IndexFixture extends ActiveFixture
{
    public $modelClass = 'luya\crawler\models\Index';

    public function getData()
    {
        return [
            'index1' => [
                'url' => 'index1.php',
                'title' => 'aaa',
                'content' => 'bbb',
                'description' => 'ccc',
                'language_info' => 'en',
            ],
            'index2' => [
                'url' => 'index2.php',
                'title' => 'index2',
                'content' => 'words some other drinking words and now bug is the word',
                'description' => 'index2',
                'language_info' => 'en',
            ],
            'index3' => [
                'url' => 'index2.php',
                'title' => 'index2',
                'content' => 'stem drink stem find stem',
                'description' => 'index2',
                'language_info' => 'en',
            ],
        ];
    }
}
