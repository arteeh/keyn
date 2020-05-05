<?php

function createuser($username, $email, $password)
{
	$userdbdir = "db/user";

	echo "createuser(): entering<br>";
	$usernamehash = hash("sha256", $username);
	$emailhash = hash("sha256", $email);
	$passwordhash = password_hash($password, PASSWORD_BCRYPT);

	$userdir = "$userdbdir/$usernamehash";
	$userdatapath = "$userdir/data";
	$useravatarpathplaceholder = "$userdbdir/placeholderuser/avatar.webp";
	$useravatarpath = "$userdir/avatar.webp";
	
	echo "createuser(): creating directory $userdir<br>";
	echo mkdir($userdir) . "<br>";
	echo "createuser(): copying avatar<br>";
	copy($useravatarpathplaceholder, $useravatarpath);
	
	echo "createuser(): writing data to data file<br>";
	$datafile = fopen($userdatapath, 'w');
	fwrite($datafile, "username=$usernamehash\n");
	fwrite($datafile, "email=$emailhash\n");
	fwrite($datafile, "password=$passwordhash\n");
	fwrite($datafile, "verified=0\n");
	fclose($datafile);
	
	echo "createuser(): leaving<br>";
}

function replacestringinfile($filename, $toreplace, $replacewith)
{
	echo "replacestringinfile(): entering<br>";
	$content=file_get_contents($filename);
	$contentchunks=explode($toreplace, $content);
	$content=implode($replacewith, $contentchunks);
	file_put_contents($filename, $content);
	echo "replacestringinfile(): leaving<br>";
}

function verifyuser($username, $token)
{
	echo "verifyuser(): entering<br>";
	
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
			$datapath = "$userdir/data";
			$datafile = fopen($datapath);
			while(!feof($datafile))
			{
				$line = fgets($datafile);
				if(strpos($line, 'verified=') !== false)
					$isverified = trim($line,"verified=");
			}
			fclose($datapath);
			
			if($isverified == '0')
			{
				replacestringinfile($datapath,
					"verified=0",
					"verified=1");
				echo "verifyuser(): verified";
				$retval = 1;
			}
			else if ($isverified == '1')
				echo "verifyuser(): already verified";
		}
		else echo "verifyuser(): not a dir";
	}
	else echo "verifyuser(): hash incorrect";
	
	echo "verifyuser(): entering<br>";
	return $retval;
}

?>
