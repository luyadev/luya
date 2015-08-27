<?php

namespace crawler\classes;

use yii\base\InvalidConfigException;
use yii\base\yii\base;
use luya\helpers\Url;

class CrawlPage extends \yii\base\Object
{
    public $pageUrl = null;

    public $client = null;

    private $_crawler = null;

    public function __clone()
    {
        $this->flush();
    }

    public function init()
    {
        if ($this->client === null) {
            throw new InvalidConfigException('client properties can not be null.');
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
            $this->_crawler = $this->client->request('GET', $this->pageUrl);
        }

        return $this->_crawler;
    }

    public function getLinks()
    {
        $links = $this->getCrawler()->filter('a')->each(function ($node, $i) {
            return $node->extract(array('_text', 'href'))[0];
        });

        foreach ($links as $key => $item) {
            $url = parse_url($item[1]);

            if (!isset($url['host'])) {
                $host = $this->getBaseUrl();
            } else {
                $host = $url['host'];
            }

            $links[$key][1] = http_build_url(Url::trailing($host).ltrim(isset($url['path']) ? $url['path'] : '', '/'), [
                'query' => (isset($host['query'])) ? $host['query'] : [],
            ], HTTP_URL_JOIN_QUERY | HTTP_URL_STRIP_FRAGMENT);
        }

        return $links;
    }

    public function getBaseUrl()
    {
        $base = $this->getCrawler()->filter('base');
        $data = $base->extract(array('href'));

        if (isset($data[0])) {
            return Url::trailing($data[0]);
        }

        return false;
    }

    public function getContent()
    {
        $content = trim($this->getCrawler()->filter('body')->text());

        return preg_replace('/\s+/', ' ', $content);
    }
}
