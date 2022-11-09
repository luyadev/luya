<?php

namespace luya\tag\tags;

use luya\tag\BaseTag;
use yii\helpers\Html;

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
     * @var boolean Whether email obfuscation is enabled or not.
     * @since 1.0.15
     */
    public $obfuscate = true;

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
        $label = $sub ?: $value;

        // if obfuscation is enabled generate tag string due to yii tag method will encode attributes.
        if ($this->obfuscate) {
            if (!$sub) {
                $label = $this->obfuscate($label);
            }
            return '<a href="'.$this->obfuscate("mailto:{$value}").'" rel="nofollow">'.$label.'</a>';
        }

        return Html::mailto($label, $value, [
            'rel' => 'nofollow',
        ]);
    }

    /**
     * Obfucscate email adresse
     *
     * @param string $email
     * @return string
     * @see http://php.net/manual/de/function.bin2hex.php#11027
     */
    public function obfuscate($email)
    {
        $output = null;
        for ($i = 0; $i < strlen($email); $i++) {
            $output .= '&#'.ord($email[$i]).';';
        }

        return $output;
    }
}
