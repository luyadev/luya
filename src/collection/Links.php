<?php
namespace luya\collection;

class Links extends \luya\base\Collection implements \luya\collection\LinksInterface
{
    private $links = [];

    public function getAll()
    {
        return $this->links;
    }

    public function getByArguments(array $argsArry)
    {
        $_index = $this->getAll();

        foreach ($argsArry as $key => $value) {
            foreach ($_index as $link => $args) {
                if (!isset($args[$key])) {
                    unset($_index[$link]);
                }

                if (isset($args[$key]) && $args[$key] !== $value) {
                    unset($_index[$link]);
                }
            }
        }

        return $_index;
    }
    public function addLink($link, $args)
    {
        $this->links[$link] = $args;
    }

    public function getLink($link)
    {
        return $this->links[$link];
    }

    private $activeLink;

    public function setActiveLink($activeLink)
    {
        $this->activeLink = $activeLink;
    }

    public function getActiveLink()
    {
        return $this->activeLink;
    }
}
