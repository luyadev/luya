<?php

namespace luya\crawler\frontend\classes;

use Goutte\Client;
use yii\base\InvalidConfigException;
use luya\helpers\Url;
use luya\helpers\StringHelper;
use Symfony\Component\DomCrawler\Crawler;

class CrawlPage extends \yii\base\Object
{
    public $pageUrl = null;

    public $client = null;

    public $baseUrl = null;
    
    public $baseHost = null;
    
    public $useH1 = false;
    
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

    public function setCrawler(Crawler $crawler)
    {
        $this->_crawler = $crawler;
    }
    
    public function getCrawler()
    {
        if ($this->_crawler === null) {
            try {
                $this->client = new Client();
                $this->_crawler = $this->client->request('GET', $this->pageUrl);
                if ($this->client->getInternalResponse()->getStatus() !== 200) {
                    $this->verbosePrint("[!] " .$this->pageUrl, "Response Status is not 200");
                    $this->_crawler = false;
                }
            } catch (\Exception $e) {
                $this->_crawler = false;
            }
        }

        return $this->_crawler;
    }
    
    public function getCrawlerHtml()
    {
        try {
            $crawler = $this->getCrawler();
            
            if (!$crawler) {
                return '';
            }
            
            $crawler->filter('script')->each(function (Crawler $crawler) {
                foreach ($crawler as $node) {
                    $node->parentNode->removeChild($node);
                }
            });
            
            return $crawler->filter('body')->html();
        } catch (\Exception $e) {
            return '';
        }
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
    
    public function getTitleTag()
    {
        $crawler = $this->getCrawler();
        
        if (!$crawler) {
            return null;
        }
        
        $text = $crawler->filterXPath('//title')->text();
        
        if (!empty($text)) {
            return $text;
        }
        
        return null;
    }

    public function getTitle()
    {
        $crawler = $this->getCrawler();
        
        if (!$crawler) {
            return null;
        }
        
        $tag = $this->getTitleCrawlerTag();
        
        if (!empty($tag)) {
            return $tag;
        }
        
        $text = $this->getTitleTag();
        
        $this->verbosePrint('? getTitle(): title tag found', $text);
        if ($this->useH1) {
            $h1 = $this->getTitleH1();
            
            if (!empty($h1)) {
                return $h1;
            }
        }
        
        return $text;
    }
    
    public function getMetaKeywords()
    {
        $crawler = $this->getCrawler();
        
        if (!$crawler) {
            return null;
        }
        
        $descriptions = $crawler->filterXPath("//meta[@name='keywords']")->extract(['content']);
        
        if (isset($descriptions[0])) {
            return str_replace(",", " ", $descriptions[0]);
        }
        
        return null;
    }
    
    public function getMetaDescription()
    {
        $crawler = $this->getCrawler();
        
        if (!$crawler) {
            return null;
        }
        
        $descriptions = $crawler->filterXPath("//meta[@name='description']")->extract(['content']);
        
        if (isset($descriptions[0])) {
            return self::cleanupString($descriptions[0]);
        }
        
        return null;
    }
    
    public function getTitleH1()
    {
        $crawler = $this->getCrawler();
        
        if (!$crawler) {
            return null;
        }
        
        $response = $crawler->filter('h1')->each(function ($node, $i) {
            if (!empty($node->text())) {
                return self::cleanupString($node->text());
            }
        });
        
        if (!empty($response) && isset($response[0])) {
            $this->verbosePrint('? getTitle(): h1 tag found', $response[0]);
            return $response[0];
        }
            
        return null;
    }
    
    public function getTitleCrawlerTag()
    {
        $content = $this->getCrawlerHtml();
        
        preg_match_all("/\[CRAWL_TITLE\](.*?)\[\/CRAWL_TITLE\]/", $content, $results);
        
        if (!empty($results) && isset($results[1]) && isset($results[1][0])) {
            $this->verbosePrint("[+] CRAWL_TITLE FOUND", $results[1][0]);
            return $results[1][0];
        }
        
        return false;
    }
    
    public function getGroup()
    {
        try {
            $content = $this->getCrawlerHtml();
    
            preg_match_all("/\[CRAWL_GROUP\](.*?)\[\/CRAWL_GROUP\]/", $content, $results);
    
            if (!empty($results) && isset($results[1]) && isset($results[1][0])) {
                $this->verbosePrint("[+] CRAWL_GROUP information found", $results[1][0]);
                return $results[1][0];
            }
    
            return '';
        } catch (\Exception $e) {
            return '';
        }
    }

    private function tempGetContent()
    {
        try {
            $bodyContent = preg_replace('/\s+/', ' ', $this->getCrawlerHtml());
            
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
                
                $bodyContent .= $this->getMetaDescription();
                $bodyContent .= $this->getMetaKeywords();
                $bodyContent .= $this->getTitleTag();
            }
            
            return $bodyContent;
        } catch (\Exception $e) {
            return '';
        }
    }
    
    public function getContent()
    {
        try {
            $this->verbosePrint('get content for', $this->pageUrl);
            return self::cleanupString($this->tempGetContent());
        } catch (\Exception $e) {
            return '';
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
