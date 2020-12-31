<?php

function getMod($gameid,$modid)
{
	$mod = array();
	
	$moddir = "db/games/$gameid/mods/$modid";
	
	$mod['id'] =				$modid;
	$mod['logodir'] =			"$moddir/logo.webp";
	$mod['bannerdir'] =			"$moddir/banner.webp";
	$mod['descriptiondir'] =	"$moddir/description";
	
	$moddatadir = "$moddir/data";
	$moddatafile = fopen($moddatadir, "r");
	while(!feof($moddatafile))
	{
		$line = fgets($moddatafile);
		if		(strpos($line, 'name='		) !== false)
			$mod['name']		= trim(str_replace("name=",		"",$line));
		else if	(strpos($line, 'downloads='	) !== false)
			$mod['downloads']	= trim(str_replace("downloads=","",$line));
		else if	(strpos($line, 'seeders='	) !== false)
			$mod['seeders']		= trim(str_replace("seeders=",	"",$line));
		else if	(strpos($line, 'leechers='	) !== false)
			$mod['leechers']	= trim(str_replace("leechers=",	"",$line));
		else if	(strpos($line, 'updated='	) !== false)
			$mod['updated']		= trim(str_replace("updated=",	"",$line));
		else if	(strpos($line, 'released='	) !== false)
			$mod['released']	= trim(str_replace("released=",	"",$line));
	}
	fclose($moddatafile);
	
	return $mod;
}

function getMods($gameid)
{
	$mods = array();
	
	$gamedir = "db/games/$gameid";
	$modopendir = opendir("$gamedir/mods");
	while (($modid = readdir($modopendir)) !== false)
	{
		if(!is_dir($modid))
		{
			array_push($mods,getMod($gameid,$modid));
		}
	}
	closedir($modopendir);
	
	return $mods;
}

function createMod($gameid,$modname,$moddescription)
{
	$modid = 0;
	
	$modsdir = "db/games/$gameid/mods";
	
	// Find an unused modid
	$modsdirarray = array();
	
	$modsopendir = opendir($modsdir);
	while(($entry = readdir($modsopendir)) !== false)
	{
		if ($entry != "." && $entry != "..")
		{
			array_push($modsdirarray,$entry);
		}
	}
	closedir($modsopendir);
	
	// For no reason at all, the list of modids is random, so sort it.
	sort($modsdirarray);
	
	foreach($modsdirarray as $filename)
	{
		if(strcmp($filename,strval($modid)) == 0)
			$modid++;
	}
	
	$moddir = "$modsdir/$modid";
	
	// Create folder named modid
	mkdir($moddir);
	
	// Create data file
	$datapath = "$moddir/data";
	$currentdate = date("Y-m-d");
	$datafile = fopen($datapath, 'w');
	fwrite($datafile, "name=$modname\n");
	fwrite($datafile, "downloads=0\n");
	fwrite($datafile, "seeders=0\n");
	fwrite($datafile, "leechers=0\n");
	fwrite($datafile, "updated=$currentdate\n");
	fwrite($datafile, "released=$currentdate\n");
	fclose($datafile);
	
	// Create description file
	$descriptionpath = "$moddir/description";
	$descriptionfile = fopen($descriptionpath, 'w');
	fwrite($descriptionfile,$moddescription);
	fclose($descriptionfile);
	
	// Create downloads folder
	mkdir("$moddir/files");
	
	// TODO: Place banner in folder
	
	// TODO: Place logo in folder
	
	return $modid;
}

function createFile($modid,$filetitle,$filetorrent,$filedescription,$filebanner)
{
	// TODO: this function
	// remember to update the parent mod's 'updated' field
}
	
function getFiles($gameid,$modid)
{
	$filesdir = "db/games/$gameid/mods/$modid/files";
	$files =		array();
	$filesopendir =	opendir($filesdir);
	while(($fileid = readdir($filesopendir)) !== false)
	{
		if ($fileid != "." && $fileid != "..")
		{
			$file = array();
			$torrents = array();
			
			$filedir = "$filesdir/$fileid";
			
			$fileopendir = opendir($filedir);
			
			while(($file = readdir($fileopendir)) !== false)
			{
				if(strpos($file, '.torrent') !== false)
				{
					$torrent = array();
					$torrent['dir'] =		$file;
					$filenoext =			str_replace(".torrent","",$file);
					$fileversion =			str_replace("-","",substr($filenoext,strrpos($filenoext,"-")));
					$filenoversion =		str_replace("-","",str_replace("$fileversion","",$filenoext));
					$torrent['version'] =	$fileversion;
					$torrent['name'] =		$filenoversion;
					array_push($torrents, $torrent);
				}
			}
			closedir($fileopendir);
			
			// Remember, the torrents for a single file are sorted here, not the files themselves
			array_multisort(array_column($torrents,'version'),SORT_DESC,$torrents);
			
			// Add this file's torrents data to the array
			$file['torrents'] = $torrents;
			$file['banner'] = "$filedir/banner.png";
			$filedatadir = "$filedir/data";
			
			$filedatafile = fopen($filedatadir, "r");
			
			while(!feof($filedatafile))
			{
				$line = fgets($filedatafile);
				if		(strpos($line, 'type=')				!== false)
					$file['type']			= trim(str_replace("type=",			"",$line));
				else if	(strpos($line, 'name=')				!== false)
					$file['name']			= trim(str_replace("name=",			"",$line));
				else if	(strpos($line, 'description=')		!== false)
					$file['description']	= trim(str_replace("description=",	"",$line));
			}
			fclose($filedatafile);
			
			if($file['type'] == "main")
			{
				// Add the main file to the beginning of the files array
				array_unshift($files,$file);
			}
			else if($file['type'] == "xtra")
			{
				// Add the xtra file to the end of the files array
				array_push($files,$file);
			}
		}
	}
	closedir($filesopendir);
	
	return $files;
}

?>
	