<?php

namespace crawler\commands;

use Goutte\Client;
use crawler\classes\CrawlContainer;
use crawler\classes\CrawlPage;
/**
 * Run:
 * php index.php command crawler crawl
 * @author nadar
 *
 */
class CrawlController extends \luya\base\Command
{
    public function actionIndex()
    {
        $url = 'http://kunstmuesumbasel.ch';
        $client = new Client();
        $pageCrawler = new CrawlPage(['client' => $client]);
        $container = new CrawlContainer(['baseUrl' => $this->module->baseUrl, 'pageCrawler' => $pageCrawler]);
        
        /*
        $client = new Client();
        $obj = new CrawlPage(['client' => $client, 'pageUrl' => 'http://localhost/luya/envs/dev/public_html/de/module-test']);
        
        var_dump($obj->getContent());
        print_r($obj->getLinks());
        */
    }
}