<?php

namespace crawler\commands;

use crawler\classes\CrawlContainer;

/**
 * Crawler command to build the index:
 * 
 * ```
 * ./vendor/bin/luya command crawler crawl
 * ```
 * 
 * Verbose while crawling
 * 
 * ```
 * ./vendor/bin/luya command crawler crawl --verbose
 * ```
 *
 * @author nadar
 */
class CrawlController extends \luya\console\Command
{
    public function actionIndex()
    {
        // sart time measuremnt
        $start = microtime(true);

        if ($this->verbose) {
            $this->output('[==================== VERBOSE ====================]');
        }
        
        $container = new CrawlContainer(['baseUrl' => $this->module->baseUrl, 'filterRegex' => $this->module->filterRegex, 'verbose' => $this->verbose]);

        if ($this->verbose) {
            $this->output('[================== VERBOSE END ==================]');
        }
        
        $timeElapsed = round((microtime(true) - $start) / 60, 2);
        
        $this->outputInfo('CRAWLER REPORT:');
        
        foreach ($container->getReport() as $type => $items) {
            if (count($items) > 0) {
                $this->outputInfo(PHP_EOL . ' ' . $type . ':');
                foreach ($items as $message) {
                    $this->output(' - ' . $message);
                }
            }
        }
        
        return $this->outputSuccess(PHP_EOL . 'Cralwer finished in ' . $timeElapsed . ' min.');
    }
}
