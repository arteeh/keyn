<?php
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile = 'cache/cached-'.substr_replace($file ,"",-4).'.php';
$cachetime = 18000;

echo "url: $url<br>";
foreach($break as $i)
	echo "break: $i<br>";
echo "<br>file: $file<br>";
echo "cachefile: $cachefile<br>";
echo "cachetime: $cachetime<br><br>";
echo "if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile))<br>";
echo "if (" . file_exists($cachefile) . " && " . time() . " - $cachetime " . " < " . filemtime($cachefile) . ")<br>";

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile))
{
	if(time() - $cachetime < filemtime($cachefile))
	{
		echo "Cached copy, generated " . date('H:i', filemtime($cachefile)). "<br>";
		readfile($cachefile);
		exit;
	}
}
else
{
	echo "Not cached. File: $file<br>";
}

ob_start(); // Start the output buffer

?>