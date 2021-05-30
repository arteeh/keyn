<?php

class User
{
	private $id			= 404;
	private $name		= "NO NAME";
	private $email		= "NO@MAIL.com";
	private $password	= "NO_PASSWORD_123";
	private $banned		= false;
	
	public function create($n,$m,$p)
	{
		$this->id		= generateId("users");
		$this->name		= $n;
		$this->email	= $m;
		$this->password	= password_hash($p,PASSWORD_DEFAULT);
		$this->banned	= false;
	}
	
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
		$dir = $GLOBALS["directory"];
		$dir .= "/objects/users/$this->id";
		
		echo 'Current user: ' . get_current_user() . "<br>";
		echo 'Current user uid: ' . getmyuid() . "<br>";
		
		echo "Checking $dir<br>";
		
		if(!file_exists($dir))
		{
			echo "Doesn't exist, creating...<br>";
			mkdir($dir);
		}
		
		file_put_contents("$dir/name",$this->name);
		file_put_contents("$dir/email",$this->email);
		file_put_contents("$dir/password",$this->password);
		
		if($this->banned)	file_put_contents("$dir/banned","1");
		else				file_put_contents("$dir/banned","0");
	}
}

?>