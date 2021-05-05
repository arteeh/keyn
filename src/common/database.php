<?php

include_once "objects/Game.php";
include_once "objects/Mod.php";

$directory	= "database";

function readData($path)
{
	$file = fopen($path,"r");
	$content = fread($file,filesize($path));
	fclose($file);
	return $content;
}

function load($object,$id)
{
	$folder = array();	
	
	$dir = "$directory/objects/$object/$id";
	if($files = scandir($dir))
	{
		foreach($files as $file)
		{
			$filepath = "$dir/$file";
			
			if ($file != "." && $file != "..")
			{
				$folder["$file"] = getData($filepath);
			}
		}
	}
	
	return $folder;
}

function generateId($object)
{
	$id = 0;

	while(true)
	{
		if(!is_dir("$directory/objects/$object/$id")) break;
		$id++;
	}

	return $id;
}

function dCheckIfExists($object,$id)
{
	if(!is_dir("$directory/objects/$object/$id"))
	{
		header("Location: error");
		die();
	}
}

function getGameArray()
{	
	$gameArray = array();
	
	$gameOpenDir = opendir("$directory/objects/games");
	while (($id = readdir($gameOpenDir)) !== false)
	{
		if (!is_dir($id))
		{
			$g = new Game();
			$g->load($id);
			array_push($gameArray, $g);
		}
	}
	closedir($gameOpenDir);

	// Sort array by downloads, descending
	// https://stackoverflow.com/questions/4282413/sort-array-of-objects-by-object-fields
	usort($gameArray,function($a,$b)
	{
		return $a->downloads < $b->downloads;
	});

	return $gameArray;
}

function getModArray($gameId)
{
	$modArray = array();
	
	$modOpenDir = opendir("$directory/objects/mods");
	while (($id = readdir($modOpenDir)) !== false)
	{
		if(!is_dir($id))
		{
			$m = new Mod();
			$m->load($id);
			
			if($m->getGameId() == $gameId)
			{
				array_push($modArray,$m);
			}
		}
	}
	closedir($modOpenDir);
	
	return $modArray;
}

?>