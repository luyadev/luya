<?php

namespace admintests\admin\helpers;

use admintests\AdminTestCase;
use luya\admin\helpers\I18n;

class I18nTest extends AdminTestCase
{
    private $json = '{"de":"Deutsch","en":"English"}';
    
    private $array = ['de' => 'Deutsch', 'en' => 'English'];
    
    public function testDecode()
    {
        $deocde = I18n::decode($this->json);
        
        $this->assertSame($this->array, $deocde);
    }
    
    public function testDecodeArray()
    {
        $decode = I18n::decodeArray([$this->json, $this->json]);
        $this->assertSame([$this->array, $this->array], $decode);
    }
    
    public function testEncode()
    {
        $encode = I18N::encode($this->array);
        
        $this->assertSame($this->json, $encode);
    }
    
    public function testFindActive()
    {
        $active = I18n::findActive($this->array);
        $this->assertSame('English', $active);
    }
    
    public function testFindActiveArray()
    {
        $active = I18n::findActiveArray([$this->array, $this->array]);
        
        $this->assertSame(['English', 'English'], $active);
    }
    
    public function testDecodeActive()
    {
        $this->assertSame('English', I18n::decodeActive($this->json));
    }
    
    public function testDecodeActiveArray()
    {
        $this->assertSame(['English', 'English'], I18n::decodeActiveArray([$this->json, $this->json]));
    }
}
