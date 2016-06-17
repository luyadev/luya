<?php

namespace crawler\commands;

use crawler\classes\CrawlContainer;
use luya\helpers\FileHelper;

/**
 * Crawler command to build the index:
 * 
 * ```
 * ./vendor/bin/luya crawler/crawl
 * ```
 * 
 * Verbose while crawling
 * 
 * ```
 * ./vendor/bin/luya crawler/crawl --verbose
 * ```
 *
 * @author nadar
 */
class CrawlController extends \luya\console\Command
{
    public function actionIndex()
    {
        try {
            // sart time measuremnt
            $start = microtime(true);
    
            if ($this->verbose) {
                $this->output('[==================== VERBOSE ====================]');
            }
            
            $container = new CrawlContainer(['baseUrl' => $this->module->baseUrl, 'filterRegex' => $this->module->filterRegex, 'verbose' => $this->verbose, 'doNotFollowExtensions' => $this->module->doNotFollowExtensions]);
    
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
            
            $this->outputInfo(PHP_EOL . 'memory usage: ' . FileHelper::humanReadableFilesize(memory_get_usage()));
            $this->outputInfo('memory peak usage: ' . FileHelper::humanReadableFilesize(memory_get_peak_usage()));
            
            return $this->outputSuccess(PHP_EOL . 'Crawler finished in ' . $timeElapsed . ' min.');
        } catch (\Exception $e) {
            return $this->outputError($e->getMessage());
        }
    }
}
