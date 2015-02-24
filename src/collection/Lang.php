<?php
namespace luya\collection;

class Lang extends \luya\base\Collection implements \luya\collection\LangInterface
{
    private $name;

    private $shortCode;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;
    }

    public function getShortCode()
    {
        return $this->shortCode;
    }

    public function evalRequest($request)
    {
        $langShortCode = $request->getQueryParam('langShortCode', null);

        if (!is_null($langShortCode)) {
            $this->setName($langShortCode);
            $this->setShortCode($langShortCode);

            return true;
        }

        // @TODO load default values, from where?
        $this->setName('de');
        $this->setShortCode('de');
    }
}
