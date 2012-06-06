<?php

// show plain text output
$page->layout = false;
header ('Content-Type: text/plain');

// our data structure
$data = array (
	'title' => 'People List',
	'show_people' => true,
	'people' => array ('Mandy', 'Mindy', 'Moody')
);

// create cache dir for twig
if (! is_dir ('cache/twig')) {
	mkdir ('cache/twig');
	chmod ('cache/twig', 0777);
}

// load twig
require_once ('lib/vendor/twig/twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register ();
$loader = new Twig_Loader_Filesystem ('apps/template-bench/views');
$twig = new Twig_Environment ($loader, array (
	'cache' => 'cache/twig'
));

// start benchmark
$start = microtime (true);
$mem = memory_get_peak_usage ();

// render the template
echo $twig->render ('twig.html', $data);

// output microtime and memory usage
echo "\n\n" . (microtime (true) - $start) . "\n";
echo format_filesize (memory_get_peak_usage () - $mem);

?>