<?php

return [
    'button' => function ($href, $name) {
        return '<a class="btn btn-primary" href="'.$href.'">'.$name.'</a>';
    },
    'teaserbox' => function ($title, $description, $buttonHref, $buttonName) {
        return '<div class="teaser-box"><h1>'.$title.'</h1><p>'.$description.'</p>'.$this->button($buttonHref, $buttonName).'</div>';
    },
];
