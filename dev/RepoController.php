<?php

namespace luya\dev;

use Curl\Curl;
use GitWrapper\GitWrapper;
use yii\console\widgets\Table;
use yii\console\Markdown;
use yii\helpers\Console;

/**
 * Dev Env cloning and updating.
 *
 * Provdes functions to clone and update the repos.
 *
 * Usage
 *
 * ```sh
 * ./vendor/bin/luyadev repo/init
 * ./vendor/bin/luyadev repo/update
 * ```
 *
 * Or clone a custom repo into the repos folder:
 *
 * ```sh
 * ./venodr/bin/luyadev repo/clone luya-module-news luyadev
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.1
 */
class RepoController extends BaseDevCommand
{
    const CONFIG_VAR_USERNAME = 'username';
    
    const CONFIG_VAR_CLONETYPE = 'cloneType';
    
    /**
     * @var string Default action is actionInit();
     */
    public $defaultAction = 'init';
    
    /**
     * @var array The default repos from luyadev
     */
    public $repos = [
        'luya',
        'luya-module-admin',
        'luya-module-cms',
    ];
    
    public $text = <<<EOT
**CLONE REPOS**

We've detected that you don't have all module repos forked to your account. You can only push changes to the forked repos, all others are **READ ONLY**.

If you want to work on a specific repo, make sure that repo is forked to your Github account.

You can also skip this command, fork the repos and rerun this command again.

**FORK ME**
EOT;
    
    /**
     * Initilize the main repos.
     *
     * @return number
     */
    public function actionInit()
    {
        // username
        $username = $this->getConfig(self::CONFIG_VAR_USERNAME);
        if (!$username) {
            $username = $this->prompt('Whats your Github username?');
            $this->saveConfig(self::CONFIG_VAR_USERNAME, $username);
        }
        
        // clonetype
        $cloneType = $this->getConfig(self::CONFIG_VAR_CLONETYPE);
        if (!$cloneType) {
            $cloneType = $this->select('Are you connected via ssh or https?', ['ssh' => 'ssh', 'http' => 'http']);
            $this->saveConfig(self::CONFIG_VAR_CLONETYPE, $cloneType);
        }
        
        $summary = [];
        $itemWithoutFork = false;
        
        // generate summary overview
        foreach ($this->repos as $repo) {
            $newRepoHome = $this->getFilesystemRepoPath($repo);
            if (file_exists($newRepoHome . DIRECTORY_SEPARATOR . '.git')) {
                $summary[] = $this->summaryItem($repo, false, true);
            } elseif ($this->forkExists($username, $repo)) {
                $summary[] = $this->summaryItem($repo, true, false);
            } else {
                $itemWithoutFork = true;
                $summary[] = $this->summaryItem($repo, false, false);
            }
        }
        
        if ($itemWithoutFork) {
            Console::clearScreen();
            $this->outputInfo($this->markdown($this->text));
            foreach ($summary as $sum) {
                if (!$sum[2] && !$sum[1]) {
                    $this->outputInfo($this->markdown("**{$sum[0]}**: https://github.com/luyadev/{$sum[0]}/fork", true));
                }
            }
            echo (new Table())->setHeaders(['Repo', 'Already initialized', 'Fork exists'])->setRows($summary)->run();
            $this->outputError("Repos without fork detected. Those repos will be initialized as READ ONLY. It means you can not push any changes to them.");
            
            if (!$this->confirm("Continue?")) {
                return $this->outputError('Abort by User.');
            }
        }
        
        // foreach summary and clone
        foreach ($summary as $sum) {
            $repo = $sum[0];
            $hasFork = $sum[2];
            $exists = $sum[1];
            
            // continue already initialized repos.
            if ($exists) {
                continue;
            }
            
            $newRepoHome = $this->getFilesystemRepoPath($repo);
            
            if ($hasFork) {
                $cloneUrl = ($cloneType == 'ssh') ? "git@github.com:{$username}/{$repo}.git" : "https://github.com/{$username}/{$repo}.git";
            } else {
                $cloneUrl = ($cloneType == 'ssh') ? "git@github.com:luyadev/{$repo}.git" : "https://github.com/{$username}/{$repo}.git";
            }
            
            $this->cloneRepo($repo, $cloneUrl, $newRepoHome, 'luyadev');
        }
        
        return $this->outputSuccess("init complete.");
    }
    
    /**
     * Update all repos to master branch from upstream.
     */
    public function actionUpdate()
    {
        $wrapper = new GitWrapper();
        
        foreach ($this->repos as $repo) {
            $wrapper->git('checkout master', 'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: checkout master ✔");
            
            $wrapper->git('fetch upstream', 'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: fetch upstream ✔");
            
            $wrapper->git('rebase upstream/master master', 'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: rebase master ✔");
        }
    }
    
    /**
     *
     * @param unknown $repo
     * @param unknown $vendor
     * @return unknown
     */
    public function actionClone($vendor = null, $repo = null)
    {
    	// if `vendor/repo` notation is provided
    	if ($vendor !== null && strpos($vendor, '/')) {
    		list($vendor, $repo) = explode("/", $vendor);	
    	}
    	
        if (empty($vendor)) {
            $vendor = $this->prompt("Enter the username/vendor for this repo (e.g. luyadev)");
        }
        
        if (empty($repo)) {
        	$repo = $this->prompt("Enter the name of the repo you like to clone (e.g. luya-module-news)");
        }
        
        return $this->cloneRepo($repo, $this->getCloneUrlBasedOnType($repo, $vendor), $this->getFilesystemRepoPath($repo), $vendor);
    }
    
    private $_gitWrapper;
    
    /**
     * @return \GitWrapper\GitWrapper
     */
    protected function getGitWrapper()
    {
        if ($this->_gitWrapper === null) {
            $this->_gitWrapper = new GitWrapper();
            $this->_gitWrapper->setTimeout(300);
        }
    
        return $this->_gitWrapper;
    }
    
    private function summaryItem($repo, $isFork, $exists)
    {
        return [$repo, $exists, $isFork];
    }
    
    private function getFilesystemRepoPath($repo)
    {
        return 'repos' . DIRECTORY_SEPARATOR . $repo;
    }
    
    private function forkExists($username, $repo)
    {
        return (new Curl())->get('https://api.github.com/repos/'.$username.'/'.$repo)->isSuccess();
    }
    
    private function markdown($text, $paragraph = false)
    {
        $parser = new Markdown();
    
        if ($paragraph) {
            return $parser->parseParagraph($text);
        }
    
        return $parser->parse($text);
    }
    
    /**
     * Return the url to clone based on config clone type (ssh/https).
     *
     * @param unknown $repo
     * @param unknown $username
     * @return string
     */
    private function getCloneUrlBasedOnType($repo, $username)
    {
        return ($this->getConfig(self::CONFIG_VAR_CLONETYPE) == 'ssh') ? "git@github.com:{$username}/{$repo}.git" : "https://github.com/{$username}/{$repo}.git";
    }
    
    /**
     * Clone a repo into the repos folder.
     *
     * @param string $repo
     * @param string $cloneUrl
     * @param string $newRepoHome
     * @param string $upstreamUsername The upstream vendor name of the repo if available.
     */
    private function cloneRepo($repo, $cloneUrl, $newRepoHome, $upstreamUsername)
    {
        $this->outputSuccess("{$repo}: cloning {$cloneUrl} ...");
        $this->getGitWrapper()->cloneRepository($cloneUrl, $newRepoHome);
        if (!empty($upstreamUsername)) {
            $this->getGitWrapper()->git('remote add upstream https://github.com/'.$upstreamUsername.'/'.$repo.'.git', $newRepoHome);
            $this->outputInfo("Configure upstream https://github.com/{$upstreamUsername}/{$repo}.git");
        }
        $this->outputSuccess("{$repo}: ✔ complete");
    }
}
