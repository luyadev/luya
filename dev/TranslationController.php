<?php

namespace luya\dev;

use luya\helpers\StringHelper;

/**
 * Dev tool for translators.
 *
 * Provides functions to add new transaltions.
 *
 * Usage
 *
 * ```sh
 * ./vendor/bin/luyadev translation/add luya-module-cms cmsadmin
 * ```
 *
 *
 *
 * @author Bennet Klarhölter <boehsermoe@me.com>
 * @since 1.0.6
 */
class TranslationController extends BaseDevCommand
{
    public $dry = false;

    public function options($actionId)
    {
        return array_merge(['dry'], parent::options($actionId));
    }

    public function actionAdd($repo, $filename, $language = "*")
    {
        $repoPath = "repos/$repo";
        $messageFiles = glob("$repoPath/src/*/messages/$language/$filename.php");

        $this->outputInfo('Following files will be affected:');
        $this->output(implode("\n", $messageFiles) . "\n");

        $key = $this->prompt('Insert translation key:');
        $text = $this->prompt('Insert translation text:');

        foreach ($messageFiles as $messageFile) {
            $content = file_get_contents($messageFile);
            $newContent = preg_replace("/(\];)/", "\t'$key' => '$text',\n$1", $content);

            if (!$this->dry) {
                file_put_contents($messageFile, $newContent);
            }
            else {
                $this->outputInfo($messageFile);
            }
        }

        if (!$this->dry) {
            if (exec("[ -d $repoPath/.git ] && command -v git")) {
                $diffCommand = "git --git-dir=$repoPath/.git --work-tree=$repoPath diff -- " . str_replace($repoPath . '/', '', implode(" ", $messageFiles));
                exec($diffCommand,$diff);
                $this->output(implode("\n", $diff));
            }

            $this->outputSuccess("Translations added. Review the changes before you commit them!");
        }
    }
}