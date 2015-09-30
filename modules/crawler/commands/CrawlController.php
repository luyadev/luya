<?php

namespace crawler\commands;

use Goutte\Client;
use crawler\classes\CrawlContainer;
use crawler\classes\CrawlPage;

/**
 * Run:
 * php index.php command crawler crawl.
 *
 * @author nadar
 */
class CrawlController extends \luya\base\Command
{
    public function actionIndex()
    {
        $client = new Client();
        $pageCrawler = new CrawlPage(['client' => $client]);
        $container = new CrawlContainer(['baseUrl' => $this->module->baseUrl, 'pageCrawler' => $pageCrawler]);
        
        $this->output(print_r($container->getReport(), true));
        
        return $this->outputSuccess("Index Crawler finished");
    }
}
