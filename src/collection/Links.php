<?php
namespace luya\collection;

class Links extends \luya\base\Collection implements \luya\collection\LinksInterface
{
    private $links = [];

    public function getAll()
    {
        return $this->links;
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
