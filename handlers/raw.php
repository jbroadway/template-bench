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

// escape function for raw output
function escape ($val, $charset = 'UTF-8') {
	return htmlspecialchars ($val, ENT_QUOTES, $charset);
}

// function to render the template
function template ($file, $data) {
	extract ($data);
	require ($file);
}

// start benchmark
$start = microtime (true);
$mem = memory_get_peak_usage ();

// render the template
template ('apps/template-bench/views/raw.php', $data);

// output microtime and memory usage
echo "\n\n" . (microtime (true) - $start) . "\n";
echo format_filesize (memory_get_peak_usage () - $mem);

?>