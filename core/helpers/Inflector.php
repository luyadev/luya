<?php

namespace luya\helpers;

use yii\helpers\BaseInflector;

/**
 * Helper methods which can be used for string transformations
 *
 * Extends the {{yii\helpers\BaseInflector}} class by:
 *
 * + {{luya\helpers\Inflector::slug()}}
 *
 * @author Martin Petrasch <martin.petrasch@zephir.ch>
 * @since 1.0.0
 */
class Inflector extends BaseInflector
{
    /**
     * From yii/helpers/BaseInflector:
     *
     * Returns a string with all spaces converted to given replacement,
     * non word characters removed and the rest of characters transliterated.
     *
     * If intl extension isn't available uses fallback that converts latin characters only
     * and removes the rest. You may customize characters map via $transliteration property
     * of the helper.
     *
     * @param string $string An arbitrary string to convert
     * @param string $replacement The replacement to use for spaces
     * @param bool $lowercase whether to return the string in lowercase or not. Defaults to `true`.
     * @param bool $transliterate whether to use a transliteration transformation or not. Defaults to `true` (=BaseInflector implementation)
     * @return string The converted string.
     */
    public static function slug($string, $replacement = '-', $lowercase = true, $transliterate = true)
    {
        if ($transliterate) {
            return parent::slug($string, $replacement, $lowercase);
        }

        $string = preg_replace('/[`%\+=\{\}\|\\\.<>\/\_]+/u', '', $string); // replace those chars with nothing
        $string = preg_replace('/[=\s—–-]+/u', $replacement, $string); // replace single and double spaces by $replacement char.
        $string = trim($string, $replacement);
        
        return $lowercase ? mb_strtolower($string) : $string;
    }
}
