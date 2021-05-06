<?php

class Torrent
{
	private $mod;
	private $torrentVersionArray	= array();
	private $id						= 404;
	private $name					= 404;
	private $description			= "NO_DESCRIPTION";
	privaet $banner					= "4.png"
	private $isMain					= true;
	
	public function getMod()					{ return $this->mod; }
	public function getTorrentVersionArray()	{ return $this->torrentVersionArray; }
	public function getId()						{ return $this->id; }
	public function getName()					{ return $this->name; }
	public function getIsMain()					{ return $this->isMain; }
	public function getDescription()			{ return $this->description; }
	
	public function load()
	{
		
	}
	
	public function save()
	{
		
	}
}

?>