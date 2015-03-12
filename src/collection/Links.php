<?php
namespace luya\collection;

class Links implements \luya\collection\LinksInterface
{
    private $links = [];

    public function getAll()
    {
        return $this->links;
    }

    public function findByArguments(array $argsArray)
    {
        $_index = $this->getAll();

        foreach ($argsArray as $key => $value) {
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

    public function findOneByArguments(array $argsArray)
    {
        $links = $this->findByArguments($argsArray);
        if (empty($links)) {
            return false;
        }

        return array_values($links)[0];
    }

    public function teardown($link)
    {
        $parent = $this->getParent($link);

        $tears[] = $this->getLink($link);
        while ($parent) {
            $tears[] = $parent;
            $link = $parent['url'];
            $parent = $this->getParent($link);
        }

        $tears = array_reverse($tears);

        return $tears;
    }

    public function getParents($link)
    {
        $parent = $this->getParent($link);

        $tears = [];
        while ($parent) {
            $tears[] = $parent;
            $link = $parent['url'];
            $parent = $this->getParent($link);
        }

        $tears = array_reverse($tears);

        return $tears;
    }

    public function getParent($link)
    {
        $link = $this->getLink($link);

        return $this->findOneByArguments(['id' => $link['parent_nav_id']]);
    }

    public function getChilds($link)
    {
        $child = $this->getChild($link);
        $tears = [];
        while ($child) {
            $tears[] = $child;
            $link = $child['url'];
            $child = $this->getChild($link);
        }

        return $tears;
    }

    public function getChild($link)
    {
        $link = $this->getLink($link);

        return $this->findOneByArguments(['parent_nav_id' => $link['id']]);
    }

    public function addLink($link, $args)
    {
        $this->links[$link] = $args;
    }

    public function getLink($link)
    {
        return $this->links[$link];
    }

    private $_activeLink;

    public function setActiveLink($activeLink)
    {
        $this->_activeLink = $activeLink;
    }

    public function getActiveLink()
    {
        return $this->_activeLink;
    }
}
