<?php

function getData($path)
{
	$file = fopen($path,"r");
	$content = fread($file,filesize($path));
	fclose($file);
	return $content;
}

function getFolder($path)
{
	return getFolderR($path, 1);
}

function getFolderR($path, $depth)
{
	$folder = array();	
	if($depth > 0)
	{
		$dir = "database/$path";
		if($files = scandir($dir))
		{
			foreach($files as $file)
			{
				$filepath = "$dir/$file";
				if ($file != "." && $file != "..")
				{
					if(is_dir($filepath)) $folder["$file"] = getFolderR("$path/$file",$depth-1);
					else $folder["$file"] = getData($filepath);
				}
			}
		}
	}

	return $folder;
}

// Check if the game exists, otherwise error
function checkGame($id)
{
	if(!is_dir("database/games/$id"))
	{
		header("Location: error");
		die();
	}
}

function checkMod($gameid, $id)
{
	if(!is_dir("database/games/$gameid/mods/$id"))
	{
		header("Location: error");
		die();
	}
}

function listArray($array)
{
	listArrayR($array,0);
}

function listArrayR($array,$tabs)
{
	foreach ($array as $key => $value)
	{
		if(!is_array($value))
		{
			for($i = 0; $i < $tabs; $i++) echo "________";
			if($key != "description") echo "$key: $value<br>";
			else echo "$key: a description<br>";
		}
		else
		{
			for($i = 0; $i < $tabs; $i++) echo "________";
			echo "an array called $key<br>";
			listArrayR($value,($tabs + 1));
		}
	}
}

?>
