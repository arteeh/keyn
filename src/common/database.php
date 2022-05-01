<?php

include_once "objects/Game.php";
include_once "objects/Mod.php";
include_once "objects/Torrent.php";
include_once "objects/Version.php";
include_once "objects/User.php";

$directory = "database";

function load($object,$id)
{
	GLOBAL $directory;
	
	$folder = array();	
	
	$dir = "$directory/objects/$object/$id";
	if($files = scandir($dir))
	{
		foreach($files as $filename)
		{
			$filepath = "$dir/$filename";
			if ($filename != "." && $filename != "..")
			{
				$folder["$filename"] = file_get_contents($filepath);
			}
		}
	}
	
	return $folder;
}

function generateId($object)
{
	GLOBAL $directory;
	
	$id = 0;

	while(true)
	{
		if(!is_dir("$directory/objects/$object/$id")) break;
		$id++;
	}

	return $id;
}

function checkIfExists($object,$id)
{
	GLOBAL $directory;
	
	if(!is_dir("$directory/objects/$object/$id"))
	{
		header("Location: error");
		die();
	}
}

// https://stackoverflow.com/questions/4282413/sort-array-of-objects-by-object-fields
function sortObjectArray($array,$value,$descending)
{
	usort($array,function($a,$b)
	{
		if($descending) return $a->$value < $b->$value;
		else			return $a->$value > $b->$value;
	});
	
	return $array;
}

function getGameArray()
{
	GLOBAL $directory;
	
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

	return $gameArray;
}

?>