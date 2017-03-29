<?php

namespace luya\components;

/**
 * Formating Dates.
 *
 * It extends the Yii2 formatter component by a signifcant configuration option which allwos you
 * to *predefine* a format for each language if no sepcific format is provided.
 *
 * ```php
 * 'components' => [
 *     'formatter' => [
 *         'dateFormats' => [
 *             'fr' => 'dd.MM.yyyy',
 *             'de' => 'php:A, d. F Y',
 *         ],
 *     ],
 * ],
 * ```
 *
 * The follwing form norms are available:
 *
 * - `php:$format` php prefixed string where $format has following options: http://php.net/manual/en/function.date.php
 * - `$format` Or without php prefix use ICU options: http://userguide.icu-project.org/formatparse/datetime#TOC-Date-Time-Format-Syntax
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Formatter extends \yii\i18n\Formatter
{
    /**
     * @var array An array with date formats to use as default values where key is the local language and value the format
     * to use for the given language.
     *
     * ```php
     * 'dateFormats' => [
     *     'fr' => 'dd.MM.yyyy',
     *     'en' => 'MM/dd/yyyy',
     * ]
     * ```
     *
     * See {{\luya\component\Formatter::dateFormat}} for more informations about valid values.
     */
    public $dateFormats = [];

    /**
     * @var array An array with datetime formats to use as default values where the key is the local language and value
     * the format to use for the given language.
     *
     * ```php
     * 'dateFormats' => [
     *     'fr' => 'HH:mm:ss',
     *     'en' => 'HH:mm:ss',
     * ]
     * ```
     *
     * See {{\luya\component\Formatter::datetimeFormat}} for more informations about valid values.
     */
    public $datetimeFormats = [];
    
    /**
     * @var array An array with time formats to use as default values where the key is the local language and value
     * the format to use for the given language.
     *
     * See {{\luya\component\Formatter::timeFormat}} for more informations about valid values.
     */
    public $timeFormats = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (isset($this->dateFormats[$this->locale])) {
            $this->dateFormat = $this->dateFormats[$this->locale];
        }
        
        if (isset($this->datetimeFormats[$this->locale])) {
            $this->datetimeFormat = $this->datetimeFormats[$this->locale];
        }
        
        if (isset($this->timeFormats[$this->locale])) {
            $this->timeFormat = $this->timeFormats[$this->locale];
        }
    }
}
