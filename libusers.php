<?php

function generateid()
{
	$idisunique = 0;
	$id = 0;
	while(!$idisunique)
	{
		$id++;
		if(!is_dir("db/users/$id")) $idisunique = 1;
	}
	return $id;
}

function createuser($username, $email, $password)
{	
	$passwordhash = password_hash($password, PASSWORD_BCRYPT);
	
	$userid = generateid();
	$userdir = "db/users/$userid";
	$userdatapath = "$userdir/data";
	$useravatarpath = "$userdir/avatar.webp";
	$useravatarpathplaceholder = "db/users/placeholderuser/avatar.webp";
	
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
		$userdir = "db/users/$userid";
		
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
