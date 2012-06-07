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

// create cache dir for smarty
if (! is_dir ('cache/smarty')) {
	mkdir ('cache/smarty');
	mkdir ('cache/smarty/c');
	mkdir ('cache/smarty/conf');
	chmod ('cache/smarty', 0777);
	chmod ('cache/smarty/c', 0777);
	chmod ('cache/smarty/conf', 0777);
}

// load smarty
require_once ('apps/template-bench/lib/smarty3/Smarty.class.php');
$smarty = new Smarty ();
$smarty->setTemplateDir ('apps/template-bench/views');
$smarty->setCompileDir ('cache/smarty/c');
$smarty->setCacheDir ('cache/smarty');
$smarty->setConfigDir ('cache/smarty/conf');
$smarty->muteExpectedErrors ();

// start benchmark
$start = microtime (true);
$mem = memory_get_peak_usage ();

// render the template
$smarty->assign ($data);
$smarty->display ('smarty3.html');

// output microtime and memory usage
echo "\n\n" . (microtime (true) - $start) . "\n";
echo format_filesize (memory_get_peak_usage () - $mem);

?>