<?php

class Game extends Database
{
	private $mods			= array();
	private $id				= 404;
	private $name			= "NO NAME";
	private $description	= "NO DESCRIPTION";
	private $logo			= "0.webp";
	private $banner			= "1.webp";
	private $downloadCount	= 404;
	private $seederCount	= 404;
	private $leecherCount	= 404;
	private $modCount		= 404;
	
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
		parent::checkIfExists("games",$id);
	}
	
	public function loadMods()
	{
		
	}
	
	public function load($id)
	{
		$folder = parent::load("games",$id);
		
		$this->id				= $id;
		$this->name				= $folder["name"];
		$this->description		= $folder["description"];
		$this->logo				= $folder["logo"];
		$this->banner			= $folder["banner"];
		$this->downloadCount	= $folder["downloadCount"];
		$this->seederCount		= $folder["seederCount"];
		$this->leecherCount		= $folder["leecherCount"];
		$this->modCount			= $folder["modCount"];
	}
	
	public function save()
	{
		
	}
}

?>