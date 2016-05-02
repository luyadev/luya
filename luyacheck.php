<?php
$tests = [
	"in_array('mod_rewrite', apache_get_modules());",
	"ini_get('short_open_tag');",
	"ini_get('error_reporting');",
	"phpversion()",
	"php_ini_loaded_file()",
];
foreach ($tests as $i => $test) {
    $result = eval('return ' . $test . ';');
    printf("%2d: [%s] %s<br />", $i + 1, $test, var_export($result, true));
}