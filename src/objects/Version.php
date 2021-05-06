<?php

class Version
{
	private $torrent;
	private $id			= 404;
	private $fileName	= "NO_NAME";
	private $number		= "NO_NUMBER";
	
	public function getTorrent()	{ return $this->torrent; }
	public function getId()			{ return $this->id; }
	public function getFileName()	{ return $this->fileName; }
	public function getNumber()		{ return $this->number; }
	
	public function load($id)
	{
		$folder = load("versions",$id);
		
		$this->id				= $id;
		$this->fileName			= $folder["fileName"];
		$this->number			= $folder["number"];
		
		$this->torrent			= new Torrent();
		$this->torrent->load($folder["torrentId"]);
	}
	
	public function save()
	{
		
	}
	
	public function toString()
	{
		$string = "<br>Version:<br>";
		
		$string .= "torrent id: ";
		$string .= $this->torrent->getId();
		$string .= "<br>";
		
		$string .= "id: ";
		$string .= $this->id;
		$string .= "<br>";
		
		$string .= "fileName: ";
		$string .= $this->fileName;
		$string .= "<br>";
		
		$string .= "number: ";
		$string .= $this->number;
		$string .= "<br>";
		
		return $string;
	}
}