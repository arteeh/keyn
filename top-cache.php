<?php

$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile = 'cache/cached-'.substr_replace($file ,"",-4).'.php';
$cachetime = 18000;

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile))
{
	echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
	readfile($cachefile);
	exit;
}
else
{
	echo "<!-- Not cached. File: $file -->\n";
}

ob_start(); // Start the output buffer

?>