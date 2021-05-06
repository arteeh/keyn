<?php

class Torrent
{
	private $mod;
	private $versionArray	= array();
	private $id				= 404;
	private $name			= 404;
	private $description	= "NO_DESCRIPTION";
	private $isMain			= false;
	private $banner			= "4.webp";
	
	public function getMod()					{ return $this->mod; }
	public function getVersionArray()			{ return $this->versionArray; }
	public function getId()						{ return $this->id; }
	public function getName()					{ return $this->name; }
	public function getIsMain()					{ return $this->isMain; }
	public function getDescription()			{ return $this->description; }
	public function getBanner()
	{
		$retVal = $GLOBALS['directory'];
		$retVal .= "/files/media/$this->banner";
		return $retVal;
	}
	
	public function loadVersionArray()
	{
		$versionPath = $GLOBALS['directory'];
		$versionPath .= "/objects/versions";
		$versionOpenDir = opendir($versionPath);
		
		while(($versionId = readdir($versionOpenDir)) !== false)
		{
			if(!is_dir($versionId))
			{
				$v = new Version();
				$v->load($versionId);
				
				if(intval($v->getTorrent()->getId()) == intval($this->id))
				{
					array_push($this->versionArray,$v);
				}
			}
		}
		
		closedir($versionOpenDir);
	}
	
	public function load($id)
	{
		$folder = load("torrents",$id);
		
		$this->id				= $id;
		$this->name				= $folder["name"];
		$this->description		= $folder["description"];
		$this->banner			= $folder["banner"];
		
		$this->mod				= new Mod();
		$this->mod->load($folder["modId"]);
		
		if($folder["isMain"] == "1") $this->isMain = true;
		else $this->isMain = false;
	}
	
	public function save()
	{
		
	}
	
	public function toString()
	{
		$string = "<br>Mod:<br>";
		
		$string .= "mod id: ";
		$string .= $this->mod->getId();
		$string .= "<br>";
		
		$string .= "id: ";
		$string .= $this->id;
		$string .= "<br>";
		
		$string .= "name: ";
		$string .= $this->name;
		$string .= "<br>";
		
		$string .= "description: ";
		$string .= $this->description;
		$string .= "<br>";
		
		$string .= "isMain: ";
		if($this->isMain) $string .= "true";
		else $string .= "false";
		$string .= "<br>";
		
		$string .= "banner: ";
		$string .= $this->banner;
		$string .= "<br>";
		
		return $string;
	}
}

?>