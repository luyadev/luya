<?php

namespace luya\web;

use luya\base\Widget;
use luya\Exception;
use luya\helpers\FileHelper;
use luya\helpers\StringHelper;
use luya\traits\CacheableTrait;
use Yii;

/**
 * @property string $folder The base folder path. Default is "@webroot/svg"
 *
 * Svg "inserter"
 * This Widget will insert the contents of a given SVG file at the widgets position
 *
 * ```php
 *  <?= Svg::widget([
 *     'folder' => Yii::alias("@webroot/images/svg"),
 *     'file' => 'logos/logo.svg',
 *     'cssClss' => 'additianl-class-for-css'
 * ]); ?>
 * ```
 *
 * @author Marc Stampfli <marc@zephir.ch>
 * @since 1.0.0
 */
class Svg extends Widget
{
    use CacheableTrait;

    /**
     * @var string Relative path to the SVG file base on $folder
     */
    public $file;

    /**
     * @var string Additional css class to add to the SVG element, use only if the SVG itself has no class
     */
    public $cssClass;

    /**
     * @var string The base folder path. Default is "@webroot/svg"
     */
    private $_folder;

    /**
     * @param $folder
     * Sets $_folder to the given string (parsed trough Yii::getAlias())
     */
    public function setFolder($folder)
    {
        $this->_folder = Yii::getAlias($folder);
    }

    /**
     * @return string
     * Returns the folder string, if none is set it will return the default value "@webroot/svg"
     */
    public function getFolder()
    {
        if ($this->_folder === null) {
            $this->_folder = Yii::getAlias("@webroot/svg");
        }

        return rtrim($this->_folder, DIRECTORY_SEPARATOR);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        // Cache generated code
        return $this->getOrSetHasCache(['svg', $this->folder, $this->file, $this->cssClass], function () {

            // Check if file ends with .svg, if not add the extension
            $svgFile = StringHelper::endsWith($this->file, '.svg') ? $this->file : $this->file . '.svg';

            // Build the full svg file path
            $svgPath = $this->folder . DIRECTORY_SEPARATOR . $svgFile;

            // Get the svg contents
            $content = FileHelper::getFileContent($svgPath);

            // If a cssClass string is given, add it to the <svg> tag
            if ($this->cssClass && is_string($this->cssClass)) {
                $content = preg_replace('/<svg/', '<svg class="' . $this->cssClass . '"', $content);
            }

            if ($content) {
                return $content;
            }

            throw new Exception('Unable to access SVG File: ' . $svgPath);
        });
    }
}
