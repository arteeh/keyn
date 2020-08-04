<?php

function getGame($gameid)
{
	$game = array();
	
	$gamedir = "db/games/$gameid";
	
	$game['id'] = $gameid;
	$game['logopath'] = "$gamedir/logo.webp";
	$game['bannerpath'] = "$gamedir/banner.webp";
	
	$gamedatadir = "$gamedir/data";
	$gamedatafile = fopen($gamedatadir, "r");
	while(!feof($gamedatafile))
	{
		$line = fgets($gamedatafile);
		if(strpos($line, 'name=') !== false)
			$game['name'] = trim($line,"name=");
		else if(strpos($line, 'description=') !== false)
			$game['description'] = trim($line,"description=");
		else if(strpos($line, 'modcount=') !== false)
			$game['modcount'] = trim($line,"modcount=");
		else if(strpos($line, 'downloads=') !== false)
			$game['downloads'] = trim($line,"downloads=");
	}
	fclose($gamedatafile);
	
	return $game;
}

function getGames()
{	
	$games = array();
	
	$gameopendir = opendir("db/games");
	while (($gameid = readdir($gameopendir)) !== false)
	{
		if (!is_dir($gameid))
		{
			array_push($games, getGame($gameid));
		}
	}
	closedir($gameopendir);
	
	//sort by downloads, descending
	array_multisort(array_column($games, 'downloads'), SORT_DESC, $games);
	
	return $games;
}

?>