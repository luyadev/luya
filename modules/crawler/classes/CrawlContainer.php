<?php

namespace crawler\classes;

use Yii;
use Exception;
use yii\base\InvalidConfigException;
use crawleradmin\models\Builderindex;
use crawleradmin\models\Index;
use luya\helpers\Url;
use crawler\classes\CrawlPage;

class CrawlContainer extends \yii\base\Object
{
    public $baseUrl = null;

    public $baseHost = null;

    public $pageCrawler = null;

    public $filterRegex = [];
    
    public $verbose = false;
    
    private $_crawlers = [];
    
    public $log = [
        'new' => [],
        'update' => [],
        'delete' => [],
        'delete_issue' => [],
        'unchanged' => [],
        'filtered' => [],
    ];
    
    public function addLog($cat, $message)
    {
        $this->log[$cat][] = $message;
    }
    
    public function verbosePrint($key, $value = null)
    {
        if ($this->verbose) {
            echo  $key .': ' . $value . PHP_EOL;
        }
    }

    protected function getCrawler($url)
    {
        if (!array_key_exists($url, $this->_crawlers)) {
            $crawler = new CrawlPage(['baseUrl' => $this->baseUrl, 'pageUrl' => $url, 'verbose' => $this->verbose]);
            
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
        
        $this->verbosePrint('baseUrl', $this->baseUrl);
        $this->verbosePrint('baseHost', $this->baseHost);
        
        Yii::$app->db->createCommand()->truncateTable('crawler_builder_index')->execute();
        
        $this->verbosePrint('truncate of table crawerl_builder_index', 'yes');
        // init base url
        $this->urlStatus($this->baseUrl);
        $this->find();
    }

    public function find()
    {
        foreach (Builderindex::find()->where(['crawled' => 0])->all() as $item) {
            $this->urlStatus($item->url);
        }

        if (count(Builderindex::findAll(['crawled' => 0])) > 0) {
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
        $builder = Builderindex::find()->where(['is_dublication' => 0])->indexBy('url')->asArray()->all();
        $index = Index::find()->asArray()->indexBy('url')->all();

        if (count($builder) == 0) {
            throw new Exception('The crawler have not found any results. Wrong base url? Or set a rule which tracks all urls? Try to enable verbose output.');
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
            $this->addLog('delete', $deleteUrl);
            $model = Index::findOne($deletePage['id']);
            $model->delete(false);
        }

        // delete empty content empty title
        foreach (Index::find()->where(['=', 'content', ''])->orWhere(['=', 'title', ''])->all() as $page) {
            $this->addLog('delete_issue', $page->url);
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
        foreach ($this->filterRegex as $rgx) {
            $r = preg_match($rgx, $url, $results);
            if ($r === 1) {
                $this->verbosePrint('url does not match filter regex', $rgx);
                $this->addLog('filtered', $url);
                return false;
            }
        }

        $type = $this->getCrawler($url)->getContentType();
        
        if (strpos($type, 'text/html') === false) {
            $this->verbosePrint('url is not type of content "text/html"', $type);
            $this->addLog('invalid_header', $url . ' invalid header ' . $type);
            return false;
        }
        
        return true;
    }

    public function urlStatus($url)
    {
        $this->verbosePrint('Inspect URL Status', $url);
        $model = Builderindex::findUrl($url);

        if (!$model) {
            $this->verbosePrint('found in builder index', 'no');
            // add the url to the index
            if ($this->filterUrlIsValid($url)) {
                Builderindex::addToIndex($url, $this->getCrawler($url)->getTitle());
    
                // update the urls content
                $model = Builderindex::findUrl($url);
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
                            Builderindex::addToIndex($link[1], $link[0]);
                        }
                    }
                }
            }
        } else {
            $this->verbosePrint('found in builder index', 'yes');
            if (!$this->filterUrlIsValid($url)) {
                $model->delete();
            } else {
                if ($model->crawled !== 1) {
                    $model->content = $this->getCrawler($url)->getContent();
                    $model->crawled = 1;
                    $model->status_code = 1;
                    $model->last_indexed = time();
                    $model->title = $this->getCrawler($url)->getTitle();
                    $model->language_info = $this->getCrawler($url)->getLanguageInfo();
                    $model->save(false);
    
                    foreach ($this->getCrawler($url)->getLinks() as $link) {
                        if ($this->matchBaseUrl($link[1])) {
                            if ($this->filterUrlIsValid($link[1])) {
                                Builderindex::addToIndex($link[1], $link[0]);
                            }
                        }
                    }
                }
            }
        }
    }
}
