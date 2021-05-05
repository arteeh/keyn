<?php

class Mod extends Database
{
	private $game = new Game();
	private $id = 404;
	private $name = 'NO NAME';
	private $description = 'NO DESCRIPTION';
	private $logo = '2.webp';
	private $banner = '3.webp';
	private $downloads = 404;
	private $seeders = 404;
	private $leechers = 404;
	private $releasedate = 404;
	private $updatedate = 404;
	
	public function getGameId()			{ echo $this->game.getId(); }
	public function getId()				{ echo $this->id; }
	public function getName()			{ echo $this->name; }
	public function getDescription()	{ echo $this->description; }
	public function getLogo()			{ echo "$directory/files/media/$this->logo"; }
	public function getBanner()			{ echo "$directory/files/media/$this->banner"; }
	public function getDownloads()		{ echo $this->downloads; }
	public function getSeeders()		{ echo $this->seeders; }
	public function getLeechers()		{ echo $this->leechers; }
	public function getModCount()		{ echo $this->modCount; }
	
	public function checkIfExists()
	{
		parent::checkIfExists("mods",$id);
	}
	
	public function load($id)
	{
		$folder = parent::load("mods",$id);
		
		$this->game			= game->load($folder["gameId"]);
		$this->id			= $id;
		$this->name			= $folder["name"];
		$this->description	= $folder["description"];
		$this->logo			= $folder["logo"];
		$this->banner		= $folder["banner"];
		$this->downloads	= $folder["downloads"];
		$this->seeders		= $folder["seeders"];
		$this->leechers		= $folder["leechers"];
		$this->releaseDate	= $folder["releaseDate"];
		$this->updateDate	= $folder["updateDate"];
	}
	
	public function save()
	{
		
	}
}

?>