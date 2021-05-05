<?php

class Database
{
	private $directory	= "database";
	
	private function readData($path)
	{
		$file = fopen($path,"r");
		$content = fread($file,filesize($path));
		fclose($file);
		return $content;
	}
	
	public function load($object,$id)
	{
		$folder = array();	
		
		if($files = scandir("$directory/objects/$object/$id"))
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
	
	public function generateId($object)
	{
		$id = 0;
		
		while(true)
		{
			if(!is_dir("$directory/objects/$object/$id")) break;
			$id++;
		}
		
		return $id;
	}
	
	public function checkIfExists($object,$id)
	{
		$i = $this->id;
		if(!is_dir("$directory/objects/$object/$i"))
		{
			header("Location: error");
			die();
		}
	}
	
	public function getGameArray()
	{	
		$gameArray = array();
		
		$gameOpenDir = opendir("$directory/games");
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
}

?>