<?php

/**
 * Tests the memory usage of the setup of each template engine.
 * Run this from the command line via:
 *
 *     cd /path/to/your/site
 *     php apps/template-bench/handlers/setup.php
 */

require_once ('lib/Functions.php');

// elefant
$mem = memory_get_peak_usage ();
require_once ('lib/Controller.php');
require_once ('lib/Template.php');
$controller = new Controller ();
$tpl = new Template ('UTF-8', $controller);
echo "Elefant: " . format_filesize (memory_get_peak_usage () - $mem) . "\n";

// smarty
$mem = memory_get_peak_usage ();
require_once ('apps/template-bench/lib/smarty3/Smarty.class.php');
$smarty = new Smarty ();
$smarty->setTemplateDir ('apps/template-bench/views');
$smarty->setCompileDir ('cache/smarty/c');
$smarty->setCacheDir ('cache/smarty');
$smarty->setConfigDir ('cache/smarty/conf');
$smarty->muteExpectedErrors ();
echo "Smarty: " . format_filesize (memory_get_peak_usage () - $mem) . "\n";

// twig
$mem = memory_get_peak_usage ();
require_once ('lib/vendor/twig/twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register ();
$loader = new Twig_Loader_Filesystem ('apps/template-bench/views');
$twig = new Twig_Environment ($loader, array (
	'cache' => 'cache/twig'
));
echo "Twig: " . format_filesize (memory_get_peak_usage () - $mem) . "\n";

?>