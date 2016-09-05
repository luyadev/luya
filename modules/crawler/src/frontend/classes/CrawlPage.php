<?php

namespace luya\crawler\frontend\classes;

use Goutte\Client;
use yii\base\InvalidConfigException;
use yii\base\yii\base;
use luya\helpers\Url;
use luya\helpers\StringHelper;
use Symfony\Component\Dom;

class CrawlPage extends \yii\base\Object
{
    public $pageUrl = null;

    public $client = null;

    public $baseUrl = null;
    
    public $baseHost = null;
    
    public $useH1 = true;
    
    private $_crawler = null;

    public $verbose = false;
    
    public function __clone()
    {
        $this->flush();
    }

    public function init()
    {
        if ($this->baseUrl === null) {
            throw new InvalidConfigException('baseUrl properties can not be null.');
        }
        
        $info = parse_url($this->baseUrl);
        
        $this->baseHost = $info['scheme'] . '://' . $info['host'];
        
        if (isset($info['port'])) {
            $this->baseHost .= ':' . $info['port'];
        }
    }
    
    public function verbosePrint($key, $value = null)
    {
        if ($this->verbose) {
            echo  $key .': ' . $value . PHP_EOL;
        }
    }

    public function flush()
    {
        $this->_crawler = null;
        $this->pageUrl = null;
    }

    public function getCrawler()
    {
        if ($this->_crawler === null) {
            try {
                $this->client = new Client();
                $this->_crawler = $this->client->request('GET', $this->pageUrl);
            } catch (\Exception $e) {
                $this->_crawler = false;
            }
        }

        return $this->_crawler;
    }

    public function getContentType()
    {
        $crawler = $this->getCrawler();
        
        if (!$crawler) {
            return false;
        }
        
        return $this->client->getResponse()->getHeader('Content-Type');
    }
    
    public function getLinks()
    {
        try {
            $crawler = $this->getCrawler();
            
            if (!$crawler) {
                return [];
            }
            
            $links = $crawler->filterXPath('//a')->each(function ($node, $i) {
                return $node->extract(array('_text', 'href'))[0];
            });
            
            foreach ($links as $key => $item) {
                
                if (StringHelper::contains(['@'], $item[1])) {
                    unset($links[$key]);
                    continue;
                }
                
                $url = parse_url($item[1]);
    
                if (!isset($url['host']) || !isset($url['scheme'])) {
                    $base = $this->baseHost;
                } else {
                    $base = $url['scheme'] . '://' . $url['host'];
                }
                
                $path = null;
                
                if (isset($url['path'])) {
                    $path = $url['path'];
                }
                
                $url = rtrim($base, "/") . "/" . ltrim($path, "/");
                
    
                $links[$key][0] = self::cleanupString($links[$key][0]);
                $links[$key][1] = http_build_url($url, [
                    'query' => (isset($host['query'])) ? $host['query'] : [],
                ], HTTP_URL_JOIN_QUERY | HTTP_URL_STRIP_FRAGMENT);
            }
            
            return $links;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getLanguageInfo()
    {
        $crawler = $this->getCrawler();
        
        if (!$crawler) {
            return null;
        }
        
        return $crawler->filterXPath('//html')->attr('lang');
    }

    public function getTitle()
    {
        $crawler = $this->getCrawler();
        
        if (!$crawler) {
            return null;
        }
        
        $text =  $crawler->filterXPath('//title')->text();
        
        $this->verbosePrint('? getTitle(): title tag found', $text);
        if ($this->useH1) {
            
            
            $response = $crawler->filter('h1')->each(function($node, $i) use ($text) {
                if (!empty($node->text())) {
                    return self::cleanupString($node->text());
                }
            });
            
            if (!empty($response) && isset($response[0])) {
                $text = $response[0];
                $this->verbosePrint('? getTitle(): h1 tag found', $text);
            }
        }
        
        return $text;
    }

    private function tempGetContent($url)
    {
        try {
            $curl = new \Curl\Curl();
            $curl->get($url);
            $content = $curl->response;
    
            if ($curl->error) {
                $this->verbosePrint('Curl error message for url ' . $url, $curl->error_message);
            }
            
            if (empty($content)) {
                $this->verbosePrint('The curl get process returns in empty response', $url);
                return null;
            }
            
            $dom = new \DOMDocument('1.0', 'utf-8');
    
            libxml_use_internal_errors(true);
            $dom->loadHTML($content);
            libxml_clear_errors();
    
            $dom->preserveWhiteSpace = false; // remove redundant white spaces

            $body = $dom->getElementsByTagName('body');
    
            $bodyContent = null;
    
            if ($body && $body->length > 0) {
                // remove scripts
                while (($r = $dom->getElementsByTagName('script')) && $r->length) {
                    $r->item(0)->parentNode->removeChild($r->item(0));
                }
    
                $domBody = $body->item(0);
    
                $bodyContent = $dom->saveXML($domBody);
                //$bodyContent = $this->dom->saveHTML($this->domBody); // argument not allowed on 5.3.5 or less, see: http://www.php.net/manual/de/domdocument.savehtml.php
            } else {
                $this->verbosePrint('unable to find body tag, or the length of body tags', $url);
            }
    
            $bodyContent = preg_replace('/\s+/', ' ', $bodyContent);
            
            // find crawl full ignore
            preg_match("/\[CRAWL_FULL_IGNORE\]/s", $bodyContent, $output);
            if (isset($output[0])) {
                if ($output[0] == '[CRAWL_FULL_IGNORE]') {
                    $this->verbosePrint('Crawler tag found: CRAWL_FULL_IGNORE', $this->pageUrl);
                    $bodyContent = null;
                }
            }
            
            if ($bodyContent !== null) {
                // remove crawl ignore tags
                preg_match_all("/\[CRAWL_IGNORE\](.*?)\[\/CRAWL_IGNORE\]/s", $bodyContent, $output);
                if (isset($output[0]) && count($output[0]) > 0) {
                    foreach ($output[0] as $ignorPartial) {
                        $bodyContent = str_replace($ignorPartial, '', $bodyContent);
                    }
                }
            }
            
            return $bodyContent;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getContent()
    {
        try {
            $this->verbosePrint('get content for', $this->pageUrl);
            return self::cleanupString($this->tempGetContent($this->pageUrl));
        } catch (\Exception $e) {
            return null;
        }
    }
    
    public static function cleanupString($string)
    {
        // strip tags and stuff
        $content = strip_tags($string);
        
        // remove whitespaces and stuff
        $content = trim(str_replace(array("\n", "\r", "\t", "\n\r", "\r\n"), ' ', $content));
        
        return htmlentities($content, ENT_QUOTES | ENT_IGNORE, 'UTF-8');
    }
}
