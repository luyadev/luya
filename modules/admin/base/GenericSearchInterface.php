<?php

namespace admin\base;

interface GenericSearchInterface
{
    public function genericSearchFields();

    public function genericSearch($searchQuery);
}
