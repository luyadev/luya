<?php

namespace crawlerests;

use Yii;
use luyatests\data\MessageFileComperatorTrait;
use PHPUnit\Framework\TestCase;

class MessageFileTest extends TestCase
{
    use MessageFileComperatorTrait;
    
    public function testFiles()
    {
        $this->compare(__DIR__ . '/../src/admin/messages', 'en');
    }
}
