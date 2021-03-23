<?php

function getsingleitem($datadir, $key)
{
	$datafile = fopen($datadir, "r");
	while(!feof($datafile))
	{
		$line = fgets($datafile);
		if(strpos($line, "$key=") !== false)
			$value = str_replace("$key=","",$line);
			break;
	}
	fclose($datafile);
	
	return $value;
}

function generateid()
{
	$id = 0;
	while(true)
	{
		if(!is_dir("database/users/$id")) break;
		$id++;
	}
	return $id;
}

function createuser($username, $email, $password)
{	
	$passwordhash = password_hash($password, PASSWORD_BCRYPT);
	
	$userid = generateid();
	$userdir = "database/users/$userid";
	$userdatapath = "$userdir/data";
	$useravatarpath = "$userdir/avatar.webp";
	$useravatarpathplaceholder = "database/users/placeholderuser/avatar.webp";
	
	mkdir($userdir);
	
	copy($useravatarpathplaceholder, $useravatarpath);
	
	$datafile = fopen($userdatapath, 'w');

	fwrite($datafile, "username=$username\n");
	fwrite($datafile, "email=$email\n");
	fwrite($datafile, "password=$passwordhash\n");
	fwrite($datafile, "verified=0\n");
	fclose($datafile);
	
	return $userid;
}

function replacestringinfile($filename, $toreplace, $replacewith)
{
	$content=file_get_contents($filename);
	$contentchunks=explode($toreplace, $content);
	$content=implode($replacewith, $contentchunks);
	file_put_contents($filename, $content);
}

function verifyuser($userid, $token)
{
	$retval = 0;
	
	//sha256 hash the username and compare to the token to see if its all good
	$comparetoken = hash('sha256', $userid);
	if(hash_equals($token, $comparetoken))
	{
		$userdir = "database/users/$userid";
		
		//check if the user exists
		if(is_dir($userdir))
		{
			$isverified = 2;
			$userdatapath = "$userdir/data";
			$userdatafile = fopen($userdatapath, "r");
			
			while(!feof($userdatafile))
			{
				$line = fgets($userdatafile);
				if(strpos($line, 'verified=') !== false)
					$isverified = intval(trim($line,"verified="));
			}
			
			fclose($userdatafile);
			
			if($isverified == 0)
			{
				replacestringinfile($userdatapath,
					"verified=0",
					"verified=1");
				$retval = 1;
			}
			else if($isverified == 1)
			{
				//user has already been verified
				$retval = 2;
			}
		}
		else
		{
		//user doesn't exist
		$retval = 3;
		}
	}
	
	return $retval;
}

?>
