<?php

namespace tests\web\cms\helpers;

use cms\helpers\Parser;

class ParserTest extends \tests\web\Base
{
    public function testLinkParser()
    {
        $content = 'link[123] link[123](abc) link[www.google.ch] link[www.google.ch](nicht google!)';
        
        $response = Parser::encode($content);
        
        $this->assertEquals('<a href="## WIRD DURCH LINKS COMPONENT ERSETZT##">123</a> <a href="## WIRD DURCH LINKS COMPONENT ERSETZT##">abc</a> <a href="www.google.ch">www.google.ch</a> <a href="www.google.ch">nicht google!</a>', $response);
    }
}