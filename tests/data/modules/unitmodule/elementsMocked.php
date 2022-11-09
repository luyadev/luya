<?php

return [
    'button' => [function ($href, $name) {
        return '<a class="btn btn-primary" href="'.$href.'">'.$name.'</a>';
    }, ['href' => 'mock1', 'name' => 'mock2']],
];
