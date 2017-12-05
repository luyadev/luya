<?php

namespace luya\admin\aws;

use luya\admin\ngrest\base\ActiveWindow;

/**
 * Diplay Detail from ActiveRecord.
 *
 * This ActiveWindow uses the {{yii\widgets\DetailView}} Widget in order to display the data.
 *
 * Thefore you can customize all attributes to display and how to convert them:
 *
 * ```php
 * public function ngRestActiveWindows()
 * {
 *     return [
 *         ['class' => 'luya\admin\aws\DetailViewActiveWindow', 'attributes' => [
 *             'title', // nothing define will use `text`
 *             'description:html', // renders html tags
 *             'timestamp:datetime', // unix timetsamp to readable date
 *             'description:text:My Description' // Changes the label to `My Description`
 *         ]]
 *     ];
 * }
 * ```
 *
 * Available Formatters:
 *
 * + relativeTime
 * + datetime
 * + time
 * + duration
 * + email
 * + image
 * + url
 * + boolean
 * + ntext
 * + paragraphs
 * + size
 * + shortSize
 *
 * See [Formatting Guide](http://www.yiiframework.com/doc-2.0/guide-output-formatting.html)
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class DetailViewActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = '@admin';
    
    /**
     * @var array a list of attributes to be displayed in the detail view. Each array element
     * represents the specification for displaying one particular attribute.
     *
     * An attribute can be specified as a string in the format of `attribute`, `attribute:format` or `attribute:format:label`,
     * where `attribute` refers to the attribute name, and `format` represents the format of the attribute. The `format`
     * is passed to the [[Formatter::format()]] method to format an attribute value into a displayable text.
     * Please refer to [[Formatter]] for the supported types. Both `format` and `label` are optional.
     * They will take default values if absent.
     *
     * An attribute can also be specified in terms of an array with the following elements:
     *
     * - `attribute`: the attribute name. This is required if either `label` or `value` is not specified.
     * - `label`: the label associated with the attribute. If this is not specified, it will be generated from the attribute name.
     * - `value`: the value to be displayed. If this is not specified, it will be retrieved from [[model]] using the attribute name
     *   by calling [[ArrayHelper::getValue()]]. Note that this value will be formatted into a displayable text
     *   according to the `format` option. Since version 2.0.11 it can be defined as closure with the following
     *   parameters:
     *
     *   ```php
     *   function ($model, $widget)
     *   ```
     *
     *   `$model` refers to displayed model and `$widget` is an instance of `DetailView` widget.
     *
     * - `format`: the type of the value that determines how the value would be formatted into a displayable text.
     *   Please refer to [[Formatter]] for supported types.
     * - `visible`: whether the attribute is visible. If set to `false`, the attribute will NOT be displayed.
     * - `contentOptions`: the HTML attributes to customize value tag. For example: `['class' => 'bg-red']`.
     *   Please refer to [[\yii\helpers\BaseHtml::renderTagAttributes()]] for the supported syntax.
     * - `captionOptions`: the HTML attributes to customize label tag. For example: `['class' => 'bg-red']`.
     *   Please refer to [[\yii\helpers\BaseHtml::renderTagAttributes()]] for the supported syntax.
     */
    public $attributes;
    
    /**
     * @inheritdoc
     */
    public function defaultLabel()
    {
        return 'Detail';
    }
    
    /**
     * @inheritdoc
     */
    public function defaultIcon()
    {
        return 'zoom_in';
    }
    
    /**
     * Renders the index file of the ActiveWindow.
     *
     * @return string The render index file.
     */
    public function index()
    {
        return $this->render('index', [
            'model' => $this->model,
            'attributes' => $this->attributes,
        ]);
    }
}
