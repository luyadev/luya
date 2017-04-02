<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\helpers\BlockHelper;
use luya\cms\base\PhpBlock;

/**
 * File list block.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class FileListBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public $module = 'cms';

    /**
     * @inheritdoc
     */
    public $cacheEnabled = true;
    
    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_file_list_name');
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'attachment';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'files', 'label' => Module::t("block_file_list_files_label"), 'type' => 'zaa-file-array-upload'],
            ],
            'cfgs' => [
                ['var' => 'showType', 'label' => Module::t("block_file_list_files_showtype_label"), 'initvalue' => 0, 'type' => 'zaa-select', 'options' => [
                        ['value' => '1', 'label' => Module::t("block_file_list_showtype_yes")],
                        ['value' => '0', 'label' => Module::t("block_file_list_showtype_no")],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function extraVars()
    {
        return [
            'fileList' => BlockHelper::fileArrayUpload($this->getVarValue('files')),
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '{% if extras.fileList is empty %}<p class="block__empty-text">'.Module::t('block_file_list_admin_empty').'</p>{% else %}<ul>{% for fileEntry in extras.fileList %}<li><a target="_blank" href="{{ fileEntry.source_http }}">{{ fileEntry.caption }}{% if cfgs.showType == 1 %} ({{ fileEntry.extension }}){% endif %}</a></li>{% endfor %}</ul>{% endif %}';
    }
}
