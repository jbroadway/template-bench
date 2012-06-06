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

// start benchmark
$start = microtime (true);
$mem = memory_get_peak_usage ();

// render the template
echo $tpl->render ('template-bench/elefant', $data);

// output microtime and memory usage
echo "\n\n" . (microtime (true) - $start) . "\n";
echo format_filesize (memory_get_peak_usage () - $mem);

?>