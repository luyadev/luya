<?php

namespace luya\crawler\frontend\classes;

use Yii;
use Exception;
use yii\base\InvalidConfigException;
use luya\crawler\models\Builderindex;
use luya\crawler\models\Index;
use luya\helpers\Url;
use luya\crawler\frontend\classes\CrawlPage;

class CrawlContainer extends \yii\base\Object
{
    public $baseUrl = null;

    public $baseHost = null;

    public $pageCrawler = null;

    public $filterRegex = [];
    
    public $verbose = false;
    
    public $doNotFollowExtensions = false;
    
    public $useH1 = false;
    
    private $_crawlers = [];
    
    public $log = [
        'new' => [],
        'update' => [],
        'delete' => [],
        'delete_issue' => [],
        'unchanged' => [],
        'filtered' => [],
    ];
    
    private $_proccessed = [];
    
    protected function addProcessed($link)
    {
        $this->_proccessed[] = $link;
    }
    
    protected function isProcessed($link)
    {
        return in_array($link, $this->_proccessed);
    }
    
    public function addLog($cat, $message, $title = null)
    {
        $message = (empty($title)) ? $message : $message . " ({$title})";
        $this->log[$cat][] = $message;
    }
    
    public function verbosePrint($key, $value = null)
    {
        if ($this->verbose) {
            $value = is_array($value) ? print_r($value, true) : $value;
            
            echo $key . ': ' . $value . PHP_EOL;
        }
    }

    /**
     * Get the crawl page object based on its ulr.
     *
     * @param string $url The crawler object.
     * @return \luya\crawler\frontend\classes\CrawlPage
     */
    protected function getCrawler($url)
    {
        if (!array_key_exists($url, $this->_crawlers)) {
            $crawler = new CrawlPage(['baseUrl' => $this->baseUrl, 'pageUrl' => $url, 'verbose' => $this->verbose, 'useH1' => $this->useH1]);
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
        $this->verbosePrint('useH1', $this->useH1);
        $this->verbosePrint('filterRegex', $this->filterRegex);
        $this->verbosePrint('doNotFollowExtensions', $this->doNotFollowExtensions);
        
        Yii::$app->db->createCommand()->truncateTable('crawler_builder_index')->execute();
        
        $this->verbosePrint('truncate of table crawerl_builder_index', 'yes');
        // init base url
        $this->urlStatus($this->baseUrl);
        $this->find();
    }

    public function find()
    {
        foreach (Builderindex::find()->where(['crawled' => false])->asArray()->all() as $item) {
            if (!$this->isProcessed($item['url'])) {
                if ($this->urlStatus($item['url'])) {
                    $this->addProcessed($item['url']);
                }
            }
        }

        if (Builderindex::find()->where(['crawled' => false])->count() > 0) {
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
        $builder = Builderindex::find()->where(['is_dublication' => false])->indexBy('url')->asArray()->all();
        $index = Index::find()->asArray()->indexBy('url')->all();

        if (count($builder) == 0) {
            throw new Exception('The crawler have not found any results. Wrong base url? Or set a rule which tracks all urls? Try to enable verbose output.');
        }

        foreach ($builder as $url => $page) {
            if (isset($index[$url])) { // page exists in index
                if ($index[$url]['content'] == $page['content']) {
                    $this->addLog('unchanged', $url, $page['title']);
                    $update = Index::findOne(['url' => $url]);
                    $update->updateAttributes(['title' => $page['title']]);
                } else {
                    $this->addLog('update', $url, $page['title']);
                    $update = Index::findOne(['url' => $url]);
                    $update->attributes = $page;
                    $update->last_update = time();
                    $update->save(false);
                }
                unset($index[$url]);
            } else {
                $this->addLog('new', $url, $page['title']);
                $insert = new Index();
                $insert->attributes = $page;
                $insert->added_to_index = time();
                $insert->last_update = time();
                $insert->save(false);
            }
        }

        // delete not unseted urls from index
        foreach ($index as $deleteUrl => $deletePage) {
            $this->addLog('delete', $deleteUrl, $deletePage['title']);
            $model = Index::findOne($deletePage['id']);
            $model->delete(false);
        }

        // delete empty content empty title
        foreach (Index::find()->where(['=', 'content', ''])->orWhere(['=', 'title', ''])->all() as $page) {
            $this->addLog('delete_issue', $page->url, $page->title);
            $page->delete(false);
        }
    }

    public function matchBaseUrl($url)
    {
        if (strpos($url, $this->baseUrl) === false) {
            $this->verbosePrint("url '$url' does not match baseUrl '{$this->baseUrl}'");
            return false;
        }
        
        return true;
    }
    
    /**
     *
     * @param unknown $file
     * @return boolean true = valid; false = invalid does not match
     */
    public function filterExtensionFile($file)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), $this->doNotFollowExtensions)) {
            $this->verbosePrint('extenion is in doNotFollowExtensions list', $extension);
            return false;
        }
        
        return true;
    }
    
    private function filterUrlIsValid($url)
    {
        foreach ($this->filterRegex as $rgx) {
            $r = preg_match($rgx, $url, $results);
            if ($r === 1) {
                $this->verbosePrint("'" . $url . "' matches regex and will be skipped", $rgx);
                $this->addLog('filtered', $url);
                return false;
            }
        }

        if (!$this->filterExtensionFile($url)) {
            $this->verbosePrint('url is filtered from do not follow filters list', $url);
            return false;
        }
        
        $type = $this->getCrawler($url)->getContentType();
        
        if ($url !== $this->encodeUrl($url)) {
            $this->verbosePrint("filtered url '$url' cause of unallowed chars", $this->encodeUrl($url));
            $this->addLog('invalid_encode', $url . ' contains invalid chars');
            return false;
        }
        
        if (strpos($type, 'text/html') === false) {
            $this->verbosePrint('link "'.$url.'" is not type of content "text/html"', $type);
            $this->addLog('invalid_header', $url . ' invalid header ' . $type);
            return false;
        }
        
        return true;
    }

    protected function encodeUrl($url)
    {
        return preg_replace("/(a-z0-9\-\#\?\=\/\.\:)/i", '', $url);
    }

    public function urlStatus($url)
    {
        $this->verbosePrint('Inspect URL Status', $url);
        
        gc_collect_cycles();
        
        $this->verbosePrint('memory usage', memory_get_usage());
        $this->verbosePrint('memory usage peak', memory_get_peak_usage());
        
        $model = Builderindex::findUrl($this->encodeUrl($url));

        if (!$model) {
            $this->verbosePrint('found in builder index', 'no');
            // add the url to the index
            if ($this->filterUrlIsValid($url)) {
                Builderindex::addToIndex($url, $this->getCrawler($url)->getTitle(), 'unknown');
    
                // update the urls content
                $model = Builderindex::findUrl($url);
                $model->content = $this->getCrawler($url)->getContent();
                $model->group = $this->getCrawler($url)->getGroup();
                $model->title = $this->getCrawler($url)->getTitle();
                $model->description = $this->getCrawler($url)->getMetaDescription();
                $model->crawled = true;
                $model->status_code = 1;
                $model->last_indexed = time();
                $model->language_info = $this->getCrawler($url)->getLanguageInfo();
                $model->save(false);
    
                // add the pages links to the index
                foreach ($this->getCrawler($url)->getLinks() as $link) {
                    if ($this->isProcessed($link[1])) {
                        continue;
                    }
                    if ($this->matchBaseUrl($link[1])) {
                        if ($this->filterUrlIsValid($link[1])) {
                            Builderindex::addToIndex($link[1], $link[0], $url);
                        }
                    }
                }
            }
        } else {
            $this->verbosePrint('found in builder index', 'yes');
            if (!$this->filterUrlIsValid($url)) {
                $model->delete();
            } else {
                if (!$model->crawled) {
                    $model->content = $this->getCrawler($url)->getContent();
                    $model->group = $this->getCrawler($url)->getGroup();
                    $model->crawled = true;
                    $model->status_code = 1;
                    $model->last_indexed = time();
                    $model->title = $this->getCrawler($url)->getTitle();
                    $model->description = $this->getCrawler($url)->getMetaDescription();
                    $model->language_info = $this->getCrawler($url)->getLanguageInfo();
                    $model->save(false);
    
                    foreach ($this->getCrawler($url)->getLinks() as $link) {
                        if ($this->isProcessed($link[1])) {
                            continue;
                        }
                        if ($this->matchBaseUrl($link[1])) {
                            if ($this->filterUrlIsValid($link[1])) {
                                Builderindex::addToIndex($link[1], $link[0], $url);
                            }
                        }
                    }
                }
            }
        }
        
        unset($model);
        
        return true;
    }
}
