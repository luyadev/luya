<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Single Image-Upload
 *
 * @author nadar
 */
class Image extends Plugin
{
    public $noFilters = false;

    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createTag('storage-image-thumbnail-display', null, ['image-id' => "{{{$ngModel}}}"]);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-image-upload', $id, $ngModel, ['options' => json_encode(['no_filter' => $this->noFilters])]);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
