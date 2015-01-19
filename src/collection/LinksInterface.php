<?php
namespace luya\collection;

interface LinksInterface
{
    public function getActiveLink();

    public function setActiveLink($activeLink);

    public function addLink($link, $args);

    public function getAll();
}
