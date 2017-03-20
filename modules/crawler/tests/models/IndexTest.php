<?php

namespace crawlerests\models;

use luya\crawler\models\Index;
use crawlerests\CrawlerTestCase;
use crawlerests\data\fixtures\IndexFixture;

class StubIndex extends Index
{
    public $content;
    
    public function behaviors()
    {
        return [];
    }
    
    public function getNgRestPrimaryKey()
    {
        return 'id';
    }
}

class IndexTest extends CrawlerTestCase
{
    public function testPreview()
    {
        $model = new StubIndex();
        $model->content = 'Wohn- und B&uuml;rozentrum f&uuml;r K&ouml;rperbehinderte Die F&auml;higkeit z&auml;hlt, nicht die Behinderung Unterst&uuml;tzen Sie uns Geldspenden, Freiwilligenarbeit oder Partnerschaften &ndash; jegliche Form von Unterst&uuml;tzung ist herzlich willkommen.             Kunst aus dem kreativAtelier Vernissage im Lichthof: 6.12.2016, 9.30 bis 10.30 UhrAusstellung: 6.12.2016 bis 15.01.2017             Kunstausstellung Carina Tschan Vernissage im Lichthof: 20.1.2017, 14 bis 15.30 UhrAusstellung: 20.1. bis 24.3.2017             Dienstleistungen / Produkte f&uuml;r Kunden         Leistungen f&uuml;r Menschen mit Behinderung         Unterst&uuml;tzung f&uuml;r Spendende und Freiwillige         WBZ-Flohmarkt 2016 mit Jazz-Matin&eacute;e Am Freitag, 28. Oktober 2016, heisst es wieder auf die Pl&auml;tze, fertig, WBZ-Flohmarkt!  Aktuell       Neubau        6.12.2016 - 15.1.2017 - Ausstellung Kunst aus dem kreativAtelier Unter der Leitung von Marion Gregor ist im WBZ inspirierende Kunst entstanden. Die Kunstwerke werden im Lichthof (Aumattstrasse 71, 4153 Reinach) ausgestellt und zum Verkauf angeboten.  Events         &Uuml;ber uns       Tageskarte Restaurant Albatros        Stellen       WBZ-Imagefilm       WBZ-Flohmarkt Aufbau       WBZ-Flohmarkt Abbau       WBZ - Wohn- und B&uuml;rozentrum f&uuml;r K&ouml;rperbehinderte';
        $this->assertContains('zäh<span style=\'background-color:#FFEBD1; color:black;\'>l</span>t', $model->preview('l', 150));
        $this->assertSame('...llo foobar Hel...', $model->cut("foobar", "Hello foobar Hello", 3));
        $this->assertSame('Hello <span style=\'background-color:#FFEBD1; color:black;\'>foobar</span> Hello', $model->highlight('foobar', 'Hello foobar Hello'));
        $this->assertSame('Hello <span style=\'background-color:#FFEBD1; color:black;\'>foobar</span> Hello', $model->highlight('foobar', 'Hello FOOBAR Hello'));
        $this->assertSame('Hello <span style=\'background-color:#FFEBD1; color:black;\'>FOOBar</span> Hello', $model->highlight('FOOBar', 'Hello foobar Hello'));
    }
    
    public function testFlatSearchByQuery()
    {
        $fixture = new IndexFixture();
        $fixture->load();
        
        $test = Index::flatSearchByQuery('aaa', 'en');
        $this->assertSame('aaa', $test[0]->title);
        
        $test = Index::flatSearchByQuery('bbb', 'en');
        $this->assertSame('aaa', $test[0]->title);
        
        $test = Index::flatSearchByQuery('ccc', 'en');
        $this->assertSame('aaa', $test[0]->title);
        
    }
    
    public function testsearchByQuery()
    {
        $fixture = new IndexFixture();
        $fixture->load();
    
        $test1 = Index::searchByQuery('aaa', 'en');
        $this->assertSame('aaa', $test1[0]->title);
    
        $test2 = Index::searchByQuery('bbb', 'en');
        $this->assertSame('aaa', $test2[0]->title);
    
        $test3 = Index::searchByQuery('ccc', 'en');
        $this->assertSame('aaa', $test3[0]->title);
    }
    
    public function testEnhancedSearchByQuery()
    {
        $fixture = new IndexFixture();
        $fixture->load();
        
        $test1 = Index::searchByQuery('drink bug', 'en');
        $this->assertSame('index2', $test1[0]->title);
        
        $test2 = Index::searchByQuery('drinking finding', 'en');
        $this->assertSame('index3', $test2[0]->title);
        
        // test4
        $test3 = Index::searchByQuery('two words', 'en');
        $this->assertSame('index4', $test3[0]->title);
        
        $test4 = Index::searchByQuery('words two', 'en');
        $this->assertSame('index4', $test4[0]->title);
        
        $test5 = Index::searchByQuery('words two', 'en');
        $this->assertSame('index4', $test5[0]->title);
        
        $test6 = Index::searchByQuery('words two three', 'en');
        $this->assertEmpty($test6);
    }
    
    
}
