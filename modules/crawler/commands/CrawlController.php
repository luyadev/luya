<?php

namespace crawler\commands;

use crawler\classes\CrawlContainer;
use crawler\classes\CrawlPage;

/**
 * Run:
 * ./vendor/bin/luya command crawler crawl.
 *
 * @author nadar
 */
class CrawlController extends \luya\console\Command
{
    public function actionIndex()
    {
        $start = microtime(true);
        
        
        $container = new CrawlContainer(['baseUrl' => $this->module->baseUrl, 'filterRegex' => $this->module->filterRegex]);

        $this->output(print_r($container->getReport(), true));

        $timeElapsed = round((microtime(true) - $start) / 60, 2);
        return $this->outputSuccess('Cralwer finished in ' . $timeElapsed . ' min.');
    }
}
