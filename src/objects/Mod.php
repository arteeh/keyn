<?php

include_once "../common/database.php";

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
	
	public function getGameId()			{ echo $this->game.getId(); }
	public function getId()				{ echo $this->id; }
	public function getName()			{ echo $this->name; }
	public function getDescription()	{ echo $this->description; }
	public function getLogo()			{ echo "$directory/files/media/$this->logo"; }
	public function getBanner()			{ echo "$directory/files/media/$this->banner"; }
	public function getDownloadCount()	{ echo $this->downloadCount; }
	public function getSeederCount()	{ echo $this->seederCount; }
	public function getLeecherCount()	{ echo $this->leecherCount; }
	public function getModCount()		{ echo $this->modCount; }
	
	public function checkIfExists()
	{
		checkIfExists("mods",$id);
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
		
		this->game->load($folder["gameId"]);
	}
	
	public function save()
	{
		
	}
}

?>