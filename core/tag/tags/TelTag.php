<?php

namespace luya\tag\tags;

use luya\helpers\StringHelper;
use luya\tag\BaseTag;
use yii\helpers\Html;

/**
 * TagParser Telefon Tag.
 *
 * Generate a tel link which is commonly used on mobile websites in order create a click to call link.
 * `tel[+41 061 123 123]` or with with a name instead of the phone number `tel[+41 061 123 123](call us now!)`.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class TelTag extends BaseTag
{
    /**
     * An example of how to use the TelTag.
     *
     * @return string The example string
     * @see \luya\tag\TagInterface::example()
     */
    public function example()
    {
        return 'tel[+41 123 45 65](Call us!)';
    }

    /**
     * The readme instructions string for the TelTag.
     *
     * @return string The readme text.
     * @see \luya\tag\TagInterface::readme()
     */
    public function readme()
    {
        return 'Generate a tel link which is commonly used on mobile websites in order create a click to call link. tel[+41 061 123 123] or with with a name instead of the phone number tel[+41 061 123 123](call us now!).';
    }

    /**
     * Generate the Tel Tag.
     *
     * @param string $value The Brackets value `[]`.
     * @param string $sub The optional Parentheses value `()`
     * @see \luya\tag\TagInterface::parse()
     * @return string The parser tag.
     */
    public function parse($value, $sub)
    {
        return Html::a(empty($sub) ? $value : $sub, 'tel:' . $this->ensureNumber($value));
    }

    private function ensureNumber($number)
    {
        if (!StringHelper::startsWith($number, '+')) {
            $number = '+'.$number;
        }

        return str_replace(" ", "", $number);
    }
}
