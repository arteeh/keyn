<?php

class Mod
{
	private $game;
	private $id				= 404;
	private $name			= "NO NAME";
	private $description	= "NO DESCRIPTION";
	private $logo			= "2.webp";
	private $banner			= "3.webp";
	private $downloadCount	= 404;
	private $seederCount	= 404;
	private $leecherCount	= 404;
	private $releaseDate	= 404;
	private $updateDate		= 404;
	
	public function getGameId()			{ return $this->game->getId(); }
	public function getId()				{ return $this->id; }
	public function getName()			{ return $this->name; }
	public function getDescription()	{ return $this->description; }
	public function getDownloadCount()	{ return $this->downloadCount; }
	public function getSeederCount()	{ return $this->seederCount; }
	public function getLeecherCount()	{ return $this->leecherCount; }
	public function getReleaseDate()	{ return $this->releaseDate; }
	public function getUpdateDate()		{ return $this->updateDate; }
	public function getLogo()
	{
		$retVal = $GLOBALS['directory'];
		$retVal .= "/files/media/$this->logo";
		return $retVal;
	}
	public function getBanner()
	{
		$retVal = $GLOBALS['directory'];
		$retVal .= "/files/media/$this->banner";
		return $retVal;
	}
	
	public function load($id)
	{
		$folder = load("mods",$id);
		
		$this->game				= new Game();
		$this->id				= $id;
		$this->name				= $folder["name"];
		$this->description		= $folder["description"];
		$this->logo				= $folder["logo"];
		$this->banner			= $folder["banner"];
		$this->downloadCount	= $folder["downloadCount"];
		$this->seederCount		= $folder["seederCount"];
		$this->leecherCount		= $folder["leecherCount"];
		$this->releaseDate		= $folder["releaseDate"];
		$this->updateDate		= $folder["updateDate"];
		
		$this->game->load($folder["gameId"]);
	}
	
	public function save()
	{
		
	}
	
	public function toString()
	{
		$string = "<br>Mod:<br>";
		
		$string .= "id: ";
		$string .= $this->id;
		$string .= "<br>";
		
		$string .= "name: ";
		$string .= $this->name;
		$string .= "<br>";
		
		$string .= "logo: ";
		$string .= $this->logo;
		$string .= "<br>";
		
		$string .= "banner: ";
		$string .= $this->banner;
		$string .= "<br>";
		
		$string .= "downloads: ";
		$string .= $this->downloadCount;
		$string .= "<br>";
		
		$string .= "seeders: ";
		$string .= $this->seederCount;
		$string .= "<br>";
		
		$string .= "leechers: ";
		$string .= $this->leecherCount;
		$string .= "<br>";
		
		$string .= "released: ";
		$string .= $this->releaseDate;
		$string .= "<br>";
		
		$string .= "updated: ";
		$string .= $this->updateDate;
		$string .= "<br>";
		
		return $string;
	}
}

?>