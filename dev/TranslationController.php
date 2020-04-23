<?php

namespace luya\dev;

/**
 * Dev tool for translators. This is only a helper tool for developer to edit the many translation files in different repositories.
 *
 * Provides functions to add new translations.
 *
 * Usage
 *
 * ```sh
 * ./vendor/bin/luyadev translation/add luya-module-cms cmsadmin
 * ```
 *
 * @author Bennet Klarhölter <boehsermoe@me.com>
 * @since  1.0.11
 */
class TranslationController extends BaseDevCommand
{
    /**
     * @var bool Outputs the operations but will not execute anything.
     */
    public $dry = false;

    public function options($actionId)
    {
        return array_merge(['dry'], parent::options($actionId));
    }

    /**
     * Add a new translation to a repository by filename (for admin and frondend).
     *
     * @param string $repo     Name of the repo directory (e.g. luya-module-cms)
     * @param string $filename Name of the php file without suffix (e.g. cmsadmin)
     * @param string $language (Optional) Add the translation only to one language. Use shortcode e.g. en, de, ...
     */
    public function actionAdd($repo, $filename, $language = "*")
    {
        $repoPath = "repos/$repo";
        $messageFiles = glob("$repoPath/src/**/messages/$language/$filename.php") ?: glob("$repoPath/src/messages/$language/$filename.php");

        $this->outputInfo('Following files will be affected:');
        $this->output(implode("\n", $messageFiles) . "\n");

        $key = $this->prompt('Insert translation key:');
        $text = $this->prompt('Insert translation text:');

        foreach ($messageFiles as $messageFile) {
            $content = file_get_contents($messageFile);
            $newContent = preg_replace("/(\];)/", "    '$key' => '$text',\n$1", $content);

            if (!$this->dry) {
                file_put_contents($messageFile, $newContent);
            } else {
                $this->outputInfo($messageFile);
            }
        }

        if (!$this->dry) {
            if (exec("[ -d $repoPath/.git ] && command -v git")) {
                $diffCommand = "git --git-dir=$repoPath/.git --work-tree=$repoPath diff -- " . str_replace($repoPath . '/', '', implode(" ", $messageFiles));
                exec($diffCommand, $diff);
                $this->output(implode("\n", $diff));
            }

            $this->outputSuccess("Translations added. Review the changes before you commit them!");
        }
    }
}
