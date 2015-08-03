<?php
$config = [
    'id' => 'testenv',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'luya',
	'modules' => [
        'luya' => 'luya\Module',
    ]
];

return $config;