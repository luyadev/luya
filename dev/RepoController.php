<?php

namespace luya\dev;

use Curl\Curl;
use GitWrapper\GitWrapper;
use luya\helpers\FileHelper;
use Nadar\PhpComposerReader\Autoload;
use Nadar\PhpComposerReader\AutoloadSection;
use Nadar\PhpComposerReader\ComposerReader;
use yii\console\Markdown;
use yii\console\widgets\Table;
use yii\helpers\Console;

/**
 * Dev Env cloning and updating.
 *
 * Provides functions to clone and update the repos.
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
 * ./venodr/bin/luyadev repo/clone luyadev/luya-module-news
 * ```
 *
 * In order to remove an existing repo from update list
 *
 * ```sh
 * ./vendor/bin/luyadev repo/remove luya-module-news
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.1
 */
class RepoController extends BaseDevCommand
{
    public const CONFIG_VAR_USERNAME = 'username';

    public const CONFIG_VAR_CLONETYPE = 'cloneType';

    public const CONFIG_VAR_CUSTOMCLONES = 'customClones';

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
        foreach ($this->repos as $repo) {
            $this->rebaseRepo($repo, $this->getFilesystemRepoPath($repo));
        }

        foreach ($this->getConfig(self::CONFIG_VAR_CUSTOMCLONES, []) as $repo => $path) {
            $this->rebaseRepo($repo, $path);
        }
    }

    /**
     * Clone a repo into the repos folder.
     *
     * @param string $vendor
     * @param string $repo
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

        $clones = $this->getConfig(self::CONFIG_VAR_CUSTOMCLONES, []);

        $repoFileSystemPath = $this->getFilesystemRepoPath($repo);

        $clones[$repo] = $repoFileSystemPath;

        $this->cloneRepo($repo, $this->getCloneUrlBasedOnType($repo, $vendor), $repoFileSystemPath, $vendor);

        $this->saveConfig(self::CONFIG_VAR_CUSTOMCLONES, $clones);

        $composerReader = new ComposerReader($repoFileSystemPath . DIRECTORY_SEPARATOR . 'composer.json');

        if ($composerReader->canRead()) {
            $section = new AutoloadSection($composerReader);
            $autoloaders = [];
            foreach ($section as $autoload) {
                $newSrc = $repoFileSystemPath . DIRECTORY_SEPARATOR . $autoload->source;
                $autoloaders[] = ['autoload' => $autoload, 'src' => $newSrc];
            }

            if (!empty($autoloaders)) {
                foreach ($autoloaders as $item) {
                    $projectComposer = $this->getProjectComposerReader();
                    if ($projectComposer->canWrite()) {
                        $new = new Autoload($projectComposer, $item['autoload']->namespace, $item['src'], $item['autoload']->type);

                        $section = new AutoloadSection($projectComposer);
                        $section->add($new)->save();

                        $this->outputSuccess("{$repo}: autoload ✔ (namespace '{$item['autoload']->namespace}' for '{$item['autoload']->source}')");
                    }
                }

                $projectComposer = $this->getProjectComposerReader();
                $projectComposer->runCommand('dump-autoload');
            }
        }
    }

    /**
     * Remove a given repo from filesystem.
     *
     * @param string $repo The repo name like `luya-module-cms` without vendor.
     */
    public function actionRemove($repo)
    {
        FileHelper::removeDirectory($this->getFilesystemRepoPath($repo));
        $clones = $this->getConfig(self::CONFIG_VAR_CUSTOMCLONES, []);
        if (isset($clones[$repo])) {
            unset($clones[$repo]);
            $this->saveConfig(self::CONFIG_VAR_CUSTOMCLONES, $clones);
        }

        return $this->outputSuccess("Removed repo {$repo}.");
    }

    /**
     *
     * @return \Nadar\PhpComposerReader\ComposerReader
     */
    protected function getProjectComposerReader()
    {
        return new ComposerReader(getcwd() . DIRECTORY_SEPARATOR . 'composer.json');
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

    /**
     *
     * @param string $repo
     * @param string $isFork
     * @param string $exists
     * @return array
     */
    private function summaryItem($repo, $isFork, $exists)
    {
        return [$repo, $exists, $isFork];
    }

    /**
     *
     * @param string $repo
     * @return string
     */
    private function getFilesystemRepoPath($repo)
    {
        return 'repos' . DIRECTORY_SEPARATOR . $repo;
    }

    /**
     *
     * @param string $username
     * @param string $repo
     * @return boolean
     */
    private function forkExists($username, $repo)
    {
        return (new Curl())->get('https://api.github.com/repos/'.$username.'/'.$repo)->isSuccess();
    }

    /**
     *
     * @param string $text
     * @param boolean $paragraph
     * @return string
     */
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
     * @param string $repo
     * @param string $username
     * @return string
     */
    private function getCloneUrlBasedOnType($repo, $username)
    {
        return ($this->getConfig(self::CONFIG_VAR_CLONETYPE) == 'ssh') ? "git@github.com:{$username}/{$repo}.git" : "https://github.com/{$username}/{$repo}.git";
    }

    /**
     * Rebase existing repo.
     *
     * @param string $repo
     * @param string $repoFileSystemPath
     */
    private function rebaseRepo($repo, $repoFileSystemPath)
    {
        $wrapper = new GitWrapper();
        try {
            $wrapper->git('fetch upstream', $repoFileSystemPath);
            $this->outputInfo("{$repo}: fetch upstream ✔");

            $wrapper->git('checkout master', $repoFileSystemPath);
            $this->outputInfo("{$repo}: checkout master ✔");

            $wrapper->git('rebase upstream/master master', $repoFileSystemPath);
            $this->outputInfo("{$repo}: rebase master ✔");

            $wrapper->git('pull', $repoFileSystemPath);
            $this->outputInfo("{$repo}: pull ✔");
        } catch (\Exception $err) {
            $this->outputError("{$repo}: error while updating ({$repoFileSystemPath}) with message: " . $err->getMessage());
        }
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
            $this->outputInfo("{$repo}: Configure upstream https://github.com/{$upstreamUsername}/{$repo}.git ✔");
        }

        $this->outputSuccess("{$repo}: cloning ✔");
    }
}
