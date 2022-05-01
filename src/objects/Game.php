<?php

class Game
{
	private $modArray		= array();
	private $id				= 404;
	private $name			= "NO NAME";
	private $description	= "NO DESCRIPTION";
	private $logo			= "0.webp";
	private $banner			= "1.webp";
	private $downloadCount	= 404;
	private $seederCount	= 404;
	private $leecherCount	= 404;
	private $modCount		= 404;

	public function getModArray()			{ return $this->modArray; }
	public function getId()					{ return $this->id; }
	public function getName()				{ return $this->name; }
	public function getDescription()		{ return $this->description; }
	public function getDownloadCount()		{ return $this->downloadCount; }
	public function getSeederCount()		{ return $this->seederCount; }
	public function getLeecherCount()		{ return $this->leecherCount; }
	public function getModCount()			{ return $this->modCount; }
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
	
	public function loadModArray()
	{
		$modPath = $GLOBALS['directory'];
		$modPath .= "/objects/mods";
		$modOpenDir = opendir($modPath);
		
		while(($id = readdir($modOpenDir)) !== false)
		{
			if(!is_dir($id))
			{
				$m = new Mod();
				$m->load($id);
				
				if(intval($m->getGame()->getId()) == intval($this->id))
				{
					array_push($this->modArray,$m);
				}
			}
		}
		
		closedir($modOpenDir);
	}
	
	public function load($id)
	{
		$folder = load("games",$id);
		
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
	
	public function toString()
	{
		$string = "<br>Game:<br>";
		
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
		
		$string .= "mods: ";
		$string .= $this->modCount;
		$string .= "<br>";
		
		return $string;
	}
}

?>