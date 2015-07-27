<?php

namespace crawler\classes;

use Yii;
use Exception;
use yii\base\InvalidConfigException;
use crawleradmin\models\BuilderIndex;
use crawleradmin\models\Index;
use luya\helpers\Url;

class CrawlContainer extends \yii\base\Object
{
    public $baseUrl = null;
    
    public $baseHost = null;
    
    public $pageCrawler = null;
    
    private $_crawlers = [];
    
    protected function getCrawler($url)
    {
        if (!array_key_exists($url, $this->_crawlers)) {
            $crawler = clone $this->pageCrawler;
            $crawler->pageUrl = $url;
            $this->_crawlers[$url] = $crawler;
        }
        
        return $this->_crawlers[$url];
    }
    
    public function init()
    {
        if ($this->baseUrl === null) {
            throw new InvalidConfigException("argument 'baseUrl' can not be null.");
        }
        $this->baseUrl = Url::trailing($this->baseUrl);
        $this->baseHost = parse_url($this->baseUrl, PHP_URL_HOST);
        Yii::$app->db->createCommand()->truncateTable('crawler_builder_index')->execute();
        // init base url
        $this->urlStatus($this->baseUrl);
        $this->find();
    }
    
    public function find()
    {
        foreach(BuilderIndex::find()->where(['crawled' => 0])->all() as $item) {
            $this->urlStatus($item->url);
        }
        
        if (count(BuilderIndex::findAll(['crawled' => 0])) > 0) {
            $this->find();
        } else {
            $this->finish();
        }
    }
    
    public function finish()
    {
        $builder = BuilderIndex::find()->indexBy('url')->asArray()->all();
        $index = Index::find()->asArray()->indexBy('url')->all();
        
        if (count($builder) == 0) {
            throw new Exception("The array index have length 0, stop script exec.");
            exit;
        }
        
        $compare = [
            'new' => [],
            'update' => [],
            'delete' => [],
            'unchanged' => [],
        ];
        
        foreach($builder as $url => $page) {
            if (isset($index[$url])) { // page exists in index
                if ($index[$url]['content'] == $page['content']) {
                    $compare['unchanged'][] = $url;
                } else {
                    $compare['update'][] = $url;
                    $update = Index::findOne(['url' => $url]);
                    $update->attributes = $page;
                    $update->last_update = time();
                    $update->save(false);
                }
                unset($index[$url]);
            } else {
                $compare['new'][] = $url;
                $insert = new Index();
                $insert->attributes = $page;
                $insert->added_to_index = time();
                $insert->last_update = time();
                $insert->save(false);
            }
        }
        
        // delete not unseted urls from index
        foreach($index as $deleteUrl => $deletePage) {
            $model = Index::findOne($deletePage['id']);
            $model->delete(false);
        }
        
        print_r($compare);
    }
    
    public function matchBaseUrl($url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        if ($host == $this->baseHost) {
            return true;
        }
        
        return false;
    }
    
    public function urlStatus($url)
    {
        $model = BuilderIndex::findUrl($url);
        
        if (!$model) {
            
            // add the url to the index
            BuilderIndex::addToIndex($url);
            
            // update the urls content
            $model = BuilderIndex::findUrl($url);
            $model->content = $this->getCrawler($url)->getContent();
            $model->crawled = 1;
            $model->status_code = 1;
            $model->last_indexed = time();
            $model->save();
            
            // add the pages links to the index
            foreach($this->getCrawler($url)->getLinks() as $link) {
                if ($this->matchBaseUrl($link[1])) {
                    BuilderIndex::addToIndex($link[1], $link[0]);
                }
            }
            
        } else {
            if ($model->crawled !== 1) {
                $model->content = $this->getCrawler($url)->getContent();
                $model->crawled = 1;
                $model->status_code = 1;
                $model->last_indexed = time();
                $model->save();
                
                foreach($this->getCrawler($url)->getLinks() as $link) {
                    if ($this->matchBaseUrl($link[1])) {
                        BuilderIndex::addToIndex($link[1], $link[0]);
                    }
                }
            }
        }
    }
}