<?php
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
if(	$file == "register.php"	||
	$file == "login.php"	)
	$dontcache = 1;

if(!$dontcache)
{
	$cachefile = 'cache/cached-' . substr_replace($file ,"",-4);
	$questionmarked = 0;
	foreach($_GET as $key => $value)
	{
		if(!$questionmarked)
		{
			$cachefile = $cachefile . "_where_$key" . "_is_" . "$value";
			$questionmarked++;
		}
		else
			$cachefile = $cachefile . "_and_$key" . "_is_" . "$value";
	}
	$cachetimeminutes = 10;
	$cachetime = $cachetimeminutes * 60;
	// Serve from the cache if it is younger than $cachetime
	if (file_exists($cachefile))
	{
		if(time() - $cachetime < filemtime($cachefile))
		{
			echo "<!-- Cached page, generated at " . date('H:i', filemtime($cachefile)). " -->";
			readfile($cachefile);
			exit;
		}
	}
	ob_start(); // Start the output buffer
}


?>