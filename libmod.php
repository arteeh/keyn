<?php

function getMod($gameid,$modid)
{
	$mod = array();
	
	$moddir = "db/games/$gameid/mods/$modid";
	
	$mod['id'] = $modid;
	$mod['logodir'] = "$moddir/logo.webp";
	$mod['bannerdir'] = "$moddir/banner.webp";
	$mod['descriptiondir'] = "$moddir/description";
	
	$moddatadir = "$moddir/data";
	$moddatafile = fopen($moddatadir, "r");
	while(!feof($moddatafile))
	{
		$line = fgets($moddatafile);
		if(strpos($line, 'name=') !== false)
			$mod['name'] = trim(str_replace("name=","",$line));
		else if(strpos($line, 'description=') !== false)
			$mod['description'] = trim(str_replace("description=","",$line));
		else if(strpos($line, 'downloads=') !== false)
			$mod['downloads'] = trim(str_replace("downloads=","",$line));
		else if(strpos($line, 'seeders=') !== false)
			$mod['seeders'] = trim(str_replace("seeders=","",$line));
		else if(strpos($line, 'leechers=') !== false)
			$mod['leechers'] = trim(str_replace("leechers=","",$line));
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
	mkdir("$moddir/downloads");
	
	// Place banner in folder or add placeholder
	
	// Place logo in folder or add placeholder
	
	return $modid;
}

function createFile($modid,$filetitle,$filetorrent,$filedescription,$filebanner)
{
	
}
	
function getDownloads($moddir)
{
	$downloadsdir = "$moddir/downloads";
	$downloads = array();
	$downloadsopendir = opendir($downloadsdir);
	while(($downloadid = readdir($downloadsopendir)) !== false)
	{
		if ($downloadid != "." && $downloadid != "..")
		{
			$download = array();
			$torrents = array();
			
			$downloaddir = "$downloadsdir/$downloadid";
			
			$downloadopendir = opendir($downloaddir);
			
			while(($file = readdir($downloadopendir)) !== false)
			{
				if(strpos($file, '.torrent') !== false)
				{
					$torrent = array();
					$torrent['dir'] = $file;
					$filenoext = str_replace(".torrent","",$file);
					$fileversion = str_replace("-","",substr($filenoext,strrpos($filenoext,"-")));
					$filenoversion = str_replace("-","",str_replace("$fileversion","",$filenoext));
					$torrent['version'] = $fileversion;
					$torrent['name'] = $filenoversion;
					array_push($torrents, $torrent);
				}
			}
			closedir($downloadopendir);
			
			// Remember, the torrents for a single download are sorted here, not the downloads themselves
			array_multisort(array_column($torrents,'version'),SORT_DESC,$torrents);
			
			// Add this download's torrents data to the array
			$download['torrents'] = $torrents;
			$download['banner'] = "$downloaddir/banner.png";
			$downloaddatadir = "$downloaddir/data";
			
			$downloaddatafile = fopen($downloaddatadir, "r");
			
			while(!feof($downloaddatafile))
			{
				$line = fgets($downloaddatafile);
				if(strpos($line, 'type=') !== false)
					$download['type'] = trim(str_replace("type=","",$line));
				else if(strpos($line, 'name=') !== false)
					$download['name'] = trim(str_replace("name=","",$line));
				else if(strpos($line, 'description=') !== false)
					$download['description'] = trim(str_replace("description=","",$line));
			}
			fclose($downloaddatafile);
			
			if($download['type'] == "main")
			{
				// Add the main download to the beginning of the downloads array
				array_unshift($downloads,$download);
			}
			else if($download['type'] == "xtra")
			{
				// Add the xtra download to the end of the downloads array
				array_push($downloads,$download);
			}
		}
	}
	closedir($downloadsopendir);
	
	return $downloads;
}

?>
	