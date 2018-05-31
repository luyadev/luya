<?php

namespace luya\web;

use yii\base\BaseObject;
use yii\validators\RegularExpressionValidator;

/**
 * Telephone Link.
 *
 * Represent a {{luya\web\LinkInterface}} of an telephone link.
 *
 * @author Bennet Klarhölter <boehsermoe@me.com>
 * @since 1.0.9
 */
class TelephoneLink extends BaseObject implements LinkInterface
{
    use LinkTrait;

    private $_telephone;

    /**
     * Setter method for telephone number.
     *
     * If no valid telephone is provided, not value is set.
     *
     * @param string $telephone The telephone number which should be used for the tel link.
     */
    public function setTelephone($telephone)
    {
        /**
         * Hack to support leading + sign
         * @see \luya\cms\models\NavItemPageBlockItem::rules()
         * @link https://github.com/luyadev/luya/pull/1815
         */
        $telephone = ltrim($telephone, '\\');

        $validator = new RegularExpressionValidator([
            'pattern' => '#^(?:0|\+[0-9]{2})[\d- ]+$#'
        ]);
        if ($validator->validate($telephone, $error)) {
            $this->_telephone = $telephone;
        }
    }

    /**
     * Getter method for the telephone.
     *
     * @return string Returns the telephone from the setter method, if telephone is not valid null is returned.
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * @inheritdoc
     */
    public function getHref()
    {
        return empty($this->getTelephone()) ?: 'tel:' . $this->getTelephone();
    }

    /**
     * @inheritdoc
     */
    public function getTarget()
    {
        return '_self';
    }
}
