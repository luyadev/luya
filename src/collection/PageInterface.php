<?php
namespace luya\collection;

interface PageInterface
{
    public function setTitle($title);

    public function getTitle();

    public function setContent($content);

    public function getContent();
}
