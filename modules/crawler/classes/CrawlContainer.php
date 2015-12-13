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

    public $filterRegex = [];
    
    private $_crawlers = [];
    
    public $log = [
        'new' => [],
        'update' => [],
        'delete' => [],
        'delete_issue' => [],
        'unchanged' => [],
        'filtered' => [],
    ];
    
    public function addLog($cat, $message) {
        $this->log[$cat][] = $message;
    }

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
        foreach (BuilderIndex::find()->where(['crawled' => 0])->all() as $item) {
            $this->urlStatus($item->url);
        }

        if (count(BuilderIndex::findAll(['crawled' => 0])) > 0) {
            $this->find();
        } else {
            $this->finish();
        }
    }

    public function getReport()
    {
        return $this->log;
    }

    public function finish()
    {
        $builder = BuilderIndex::find()->indexBy('url')->asArray()->all();
        $index = Index::find()->asArray()->indexBy('url')->all();

        if (count($builder) == 0) {
            throw new Exception('The crawler have not found any results. Wrong base url? Or set a rule which tracks all urls?');
            exit;
        }

        foreach ($builder as $url => $page) {
            if (isset($index[$url])) { // page exists in index
                if ($index[$url]['content'] == $page['content']) {
                    $this->addLog('unchanged', $url);
                } else {
                    $this->addLog('update', $url);
                    $update = Index::findOne(['url' => $url]);
                    $update->attributes = $page;
                    $update->last_update = time();
                    $update->save(false);
                }
                unset($index[$url]);
            } else {
                $this->addLog('new', $url);
                $insert = new Index();
                $insert->attributes = $page;
                $insert->added_to_index = time();
                $insert->last_update = time();
                $insert->save(false);
            }
        }

        // delete not unseted urls from index
        foreach ($index as $deleteUrl => $deletePage) {
            $this->addLog('delete', $url);
            $model = Index::findOne($deletePage['id']);
            $model->delete(false);
        }

        // delete empty content empty title
        foreach (Index::find()->where(['=', 'content', ''])->orWhere(['=', 'title', ''])->all() as $page) {
            $this->addLog('delete_issue', $url);
            $page->delete(false);
        }
    }

    public function matchBaseUrl($url)
    {
        if (strpos($url, $this->baseUrl) === false) {
            return false;
        }
        
        return true;
    }
    
    private function filterUrlIsValid($url)
    {
        foreach($this->filterRegex as $rgx) {
            $r = preg_match($rgx, $url, $results);
            if ($r === 1) {
                $this->addLog('filtered', $url);
                return false;
            }
        }
        return true;
    }

    public function urlStatus($url)
    {
        $model = BuilderIndex::findUrl($url);

        if (!$model) {

            // add the url to the index
            if ($this->filterUrlIsValid($url)) {
                BuilderIndex::addToIndex($url, $this->getCrawler($url)->getTitle());
    
                // update the urls content
                $model = BuilderIndex::findUrl($url);
                $model->content = $this->getCrawler($url)->getContent();
                $model->crawled = 1;
                $model->status_code = 1;
                $model->last_indexed = time();
                $model->language_info = $this->getCrawler($url)->getLanguageInfo();
                $model->save(false);
    
                // add the pages links to the index
                foreach ($this->getCrawler($url)->getLinks() as $link) {
                    if ($this->matchBaseUrl($link[1])) {
                        if ($this->filterUrlIsValid($link[1])) {
                            BuilderIndex::addToIndex($link[1], $link[0]);
                        }
                    }
                }
            }
        } else {
            
            if (!$this->filterUrlIsValid($url)) {
                $model->delete();
            } else {
                if ($model->crawled !== 1) {
                    $model->content = $this->getCrawler($url)->getContent();
                    $model->crawled = 1;
                    $model->status_code = 1;
                    $model->last_indexed = time();
                    $model->language_info = $this->getCrawler($url)->getLanguageInfo();
                    $model->save(false);
    
                    foreach ($this->getCrawler($url)->getLinks() as $link) {
                        if ($this->matchBaseUrl($link[1])) {
                            if ($this->filterUrlIsValid($link[1])) {
                                BuilderIndex::addToIndex($link[1], $link[0]);
                            }
                        }
                    }
                }
            }
        }
    }
}
