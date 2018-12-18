<?php

namespace luya\tag\tags;

use yii\helpers\Html;
use luya\tag\BaseTag;

/**
 * TagParser MailTag.
 *
 * The mail Tag allows you to create E-Mail links to an address. Example use `mail[info@luya.io]` or with an additional value info use `mail[info@luya.io](send mail)`
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class MailTag extends BaseTag
{
    /**
     * An example of how to use the MailTag.
     *
     * @return string The example string
     * @see \luya\tag\TagInterface::example()
     */
    public function example()
    {
        return 'mail[info@luya.io](Mail us!)';
    }
    
    /**
     * The readme instructions string for the MailTag.
     *
     * @return string The readme text.
     * @see \luya\tag\TagInterface::readme()
     */
    public function readme()
    {
        return <<<EOT
The mail Tag allows you to create E-Mail links to an address. Example use `mail[info@luya.io]` or with an additional value info use `mail[info@luya.io](send mail)`.      
EOT;
    }
    
    /**
     * Generate the Mail Tag.
     *
     * @param string $value The Brackets value `[]`.
     * @param string $sub The optional Parentheses value `()`
     * @see \luya\tag\TagInterface::parse()
     * @return string The parser tag.
     */
    public function parse($value, $sub)
    {
        return Html::tag('a', Html::encode($sub) ?: $this->obfuscate($value), [
            'rel' => 'nofollow',
            'href' => $this->obfuscate('mailto:'.$value),
            'encoding' => false,
        ]);
    }

    /**
     * Obfucscate email adresse
     *
     * @param string $email
     * @return string
     * @see https://stackoverflow.com/a/12592364/4611030
     */
    public function obfuscate($email)
    {
        $alwaysEncode = ['.', ':', '@'];
        $result = null;
        // Encode string using oct and hex character codes
        for ($i = 0; $i < strlen($email); $i++) {
            // Encode 25% of characters including several that always should be encoded
            if (in_array($email[$i], $alwaysEncode) || mt_rand(1, 100) < 25) {
                if (mt_rand(0, 1)) {
                    $result .= '&#' . ord($email[$i]) . ';';
                } else {
                    $result .= '&#x' . dechex(ord($email[$i])) . ';';
                }
            } else {
                $result .= $email[$i];
            }
        }
    
        return $result;
    }
}
