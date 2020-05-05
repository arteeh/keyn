<?php

function createuser($username, $email, $password)
{	
	$userdbdir = "db/user";
	$usernamehash = hash("sha256", $username);
	$emailhash = hash("sha256", $email);
	$passwordhash = password_hash($password, PASSWORD_BCRYPT);

	$userdir = "$userdbdir/$usernamehash";
	$userdatapath = "$userdir/data";
	$useravatarpathplaceholder = "$userdbdir/placeholderuser/avatar.webp";
	$useravatarpath = "$userdir/avatar.webp";
	
	mkdir($userdir);
	
	copy($useravatarpathplaceholder, $useravatarpath);
	
	$datafile = fopen($userdatapath, 'w');

	fwrite($datafile, "username=$usernamehash\n");
	fwrite($datafile, "email=$emailhash\n");
	fwrite($datafile, "password=$passwordhash\n");
	fwrite($datafile, "verified=0\n");
	fclose($datafile);
}

function replacestringinfile($filename, $toreplace, $replacewith)
{
	$content=file_get_contents($filename);
	$contentchunks=explode($toreplace, $content);
	$content=implode($replacewith, $contentchunks);
	file_put_contents($filename, $content);
}

function verifyuser($username, $token)
{
	$retval = 0;
	
	$userdbdir = "db/user";
	
	//sha256 hash the username and compare to the token to see if its all good
	$comparetoken = hash('sha256', $username);
	if(hash_equals($token, $comparetoken))
	{
		$userdir = "$userdbdir/$token";
		
		//check if the user exists
		if(is_dir($userdir))
		{
			$isverified = 2;
			$datapath = "$userdir/data";
			$datafile = fopen($datapath);
			/*
			while(!feof($datafile))
			{
				
				$line = fgets($datafile);
				if(strpos($line, 'verified=') !== false)
				{
					$isverified = intval(trim($line,"verified="));
				}
				
			}
			*/
			fclose($datafile);
			
			if($isverified == 0)
			{
				replacestringinfile($datapath,
					"verified=0",
					"verified=1");
				echo "verifyuser(): verified";
				$retval = 1;
			}
			else if ($isverified == 1)
				echo "verifyuser(): already verified";
		}
		else echo "verifyuser(): not a dir";
	}
	else echo "verifyuser(): hash incorrect";
	
	return $retval;
}

?>
