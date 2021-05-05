<?php

include_once "database.php";

class User
{
	private $id			= 404;
	private $name		= "NO NAME";
	private $email		= "NO@MAIL.com";
	private $password	= "NO_PASSWORD_123";
	private $verified	= 404;
	
	public function checkIfExists()
	{
		checkIfExists("users",$id);
	}
	
	public function load($id)
	{
		$folder = load("users",$id);
		
		$this->id			= $id;
		$this->name			= $folder["name"];
		$this->email		= $folder["email"];
		$this->password		= $folder["password"];
		$this->verified		= $folder["verified"];
	}
	
	public function save()
	{
		
	}
	
	public function verify($token)
	{
		$retVal;
		
		// SHA256 hash the username and compare to the token to see if its all good
		$compareToken = hash('sha256', $name);
		
		if(hash_equals($token, $compareToken))
		{
			switch($verified)
			{
				// Not yet verified, so verify
				case 0:
					$verified = 1;
					$this->save();
					$retVal = 0;
				// Has already been verified
				case 1:
					$retVal = 1;
				// Object Hasn't been loaded yet
				case 404:
					$retVal = 404;
			}
		}
		
		return $retval;
	}
}

?>