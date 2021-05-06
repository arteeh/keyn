<?php

class User
{
	private $id			= 404;
	private $name		= "NO NAME";
	private $email		= "NO@MAIL.com";
	private $password	= "NO_PASSWORD_123";
	private $banned		= false;
	
	public function load($id)
	{
		$folder = load("users",$id);
		
		$this->id			= $id;
		$this->name			= $folder["name"];
		$this->email		= $folder["email"];
		$this->password		= $folder["password"];
		
		if($folder["banned"] == "1") $this->banned = true;
		else $this->banned = false;
	}
	
	public function save()
	{
		
	}
}

?>