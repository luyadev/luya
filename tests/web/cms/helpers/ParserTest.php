<?php

namespace tests\web\cms\helpers;

use cms\helpers\Parser;

class ParserTest extends \tests\web\Base
{
    public function testLinkBasicParser()
    {
        $content = 'link[123] link[123](abc) link[www.google.ch] link[www.google.ch](nicht google!)';
        
        $response = Parser::encode($content);
        
        $this->assertEquals('<a href="#link_not_found">123</a> <a href="#link_not_found">abc</a> <a href="http://www.google.ch">www.google.ch</a> <a href="http://www.google.ch">nicht google!</a>', $response);
    }
    
    public function testValidLinksParser()
    {
        $content = 'link[1] link test link[]';
        
        $this->assertEquals('<a href="/page-1">Page 1</a> link test link[]', Parser::encode($content));
        
        $content = 'link[1](label)';
        
        $this->assertEquals('<a href="/page-1">label</a>', Parser::encode($content));
    }
    
    public function staticLinksParser()
    {
        $this->assertEquals('<a href="http://luya.io">luya.io</a>', Parser::encode('link[http://luya.io](luya.io)'));
        $this->assertEquals('<a href="http://luya.io">Hello Whitespace</a>', Parser::encode('link[http://luya.io](Hello Whitespace)'));
        $this->assertEquals('<a href="http://luya.io">http://luya.io</a>', Parser::encode('link[http://luya.io]'));
        $this->assertEquals('<a href="http://luya.io">luya.io</a>', Parser::encode('link[luya.io]'));
        $this->assertEquals('<a href="http://luya.io">Hello Whitespace</a>', Parser::encode('link[luya.io](Hello Whitespace)'));
    }
}