<?php

namespace luyatests\core\helpers;

use luyatests\LuyaWebTestCase;
use luya\helpers\FileHelper;

class FileHelperTest extends LuyaWebTestCase
{
    public function testHumandReadableFileSize()
    {
        $this->assertSame('1 B', FileHelper::humanReadableFilesize(1));
        $this->assertSame('10 B', FileHelper::humanReadableFilesize(10));
        $this->assertSame('100 B', FileHelper::humanReadableFilesize(100));
        $this->assertSame('1000 B', FileHelper::humanReadableFilesize(1000));
        $this->assertSame('9.77 KB', FileHelper::humanReadableFilesize(10000));
        $this->assertSame('97.66 KB', FileHelper::humanReadableFilesize(100000));
        $this->assertSame('976.56 KB', FileHelper::humanReadableFilesize(1000000));
        $this->assertSame('9.54 MB', FileHelper::humanReadableFilesize(10000000));
        $this->assertSame('95.37 MB', FileHelper::humanReadableFilesize(100000000));
        $this->assertSame('953.67 MB', FileHelper::humanReadableFilesize(1000000000));
        $this->assertSame('931.32 GB', FileHelper::humanReadableFilesize(1000000000000));
        $this->assertSame('90.95 TB', FileHelper::humanReadableFilesize(100000000000000));
        $this->assertSame('88.82 PB', FileHelper::humanReadableFilesize(100000000000000000));
        
        $this->assertSame('1 MB', FileHelper::humanReadableFilesize(1048577));
    }

    public function testEnsureExtension()
    {
        $this->assertSame('path/to/image.png', FileHelper::ensureExtension('path/to/image.png', 'gif'));
        $this->assertSame('path/to/image.gif', FileHelper::ensureExtension('path/to/image', 'gif'));
        // twig example as used in element component
        $this->assertSame('file.twig', FileHelper::ensureExtension('file', 'twig'));
        $this->assertSame('path/to/file.twig', FileHelper::ensureExtension('path/to/file', 'twig'));
        $this->assertSame('path/to/file.twig', FileHelper::ensureExtension('path/to/file.', 'twig'));
        $this->assertSame('path/to/file.twig', FileHelper::ensureExtension('path/to/file.twig', 'twig'));
    }
    
    public function testGetFileInfo()
    {
        $test = FileHelper::getFileInfo('/path/to/myfile.png');
        $this->assertSame('png', $test->extension);
        $this->assertSame('myfile', $test->name);
        $test = FileHelper::getFileInfo('/path/to/myfile.');
        $this->assertFalse($test->extension);
        $this->assertSame('myfile', $test->name);
        $test = FileHelper::getFileInfo('/path/to/myfile');
        $this->assertFalse($test->extension);
        $this->assertSame('myfile', $test->name);
        $test = FileHelper::getFileInfo('/path/to/');
        $this->assertFalse($test->extension);
        $this->assertSame('to', $test->name);
        
        $empty = FileHelper::getFileInfo('');
        $this->assertFalse($empty->name);
        $this->assertFalse($empty->extension);
    }
    
    public function testGetHashFile()
    {
        $this->assertSame(false, FileHelper::md5sum('notexists.jpg'));
        $this->assertSame('7dff5cc5a1d8f04004b4a0075d3eeeae', FileHelper::md5sum(__DIR__ . '/../../data/hashfile.txt'));
    }
    
    public function testWriteFile()
    {
        $this->assertTrue(FileHelper::writeFile('@runtime/temp.txt', 'Hello World'));
        $this->assertFalse(FileHelper::writeFile('@does/not/exists/nofile.txt', 'Hello World'));
    }
    
    public function testGetFileContent()
    {
        $this->assertSame('Hello World', FileHelper::getFileContent('@runtime/temp.txt'));
        
        $this->assertFalse(FileHelper::getFileContent('doesNotExist.txt'));
    }
}
