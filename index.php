<?php require 'top.php' ?>

<div class="jumbotron my-4">
	<h1 class="display-5">
		Welcome!
	</h1>
	<p class="lead">
		Keyndb is a website where you can find, upload and download video game mods.
	</p>
	<hr class="my-4">
	<p>
		Rather than downloading the mods directly however, you get a torrent file, which you can use to download the mod using your favourite torrenting software. While this is a small hoop to jump through for you, it has many benefits. For one, download speeds will be very high and will never be artificially limited like on the Nexus. Secondly, this keeps the bandwidth needs for this website low, making it much cheaper to host the site. Because of this, there is no need for ads or subscriptions. This website is still under development, but you can try it out if you want. Enjoy!
	</p>
</div>

<?php
$gameopendir = opendir("db/games");
$games = array();

while (($gameid = readdir($gameopendir)) !== false)
{
	if (!is_dir($gameid))
	{
		$game = array();
		
		$gamedatadir = "db/games/$gameid/data";
		$gamedatafile = fopen($gamedatadir, "r");
		$game['gameid'] = $gameid;
		
		$gamelogo = "db/games/$gameid/logo.webp";
		$game['logo'] = $gamelogo;
		
		$gamename = fgets($gamedatafile);
		$gamename = trim($gamename,"name=");
		$game['name'] = $gamename;
		
		$gamedescription = fgets($gamedatafile);
		$gamedescription = trim($gamedescription,"description=");
		$game['description'] = $gamedescription;
		
		$gamemodcount = fgets($gamedatafile);
		$gamemodcount = trim($gamemodcount,"modcount=");
		$game['modcount'] = $gamemodcount;
		
		$gamedownloads = fgets($gamedatafile);
		$gamedownloads = trim($gamedownloads,"downloads=");
		$game['downloads'] = $gamedownloads;
		
		array_push($games, $game);
		
		fclose($gamedatafile);
	}
}
closedir($gameopendir);

//sort by downloads, descending
array_column($gameid, 'downloads');
array_multisort($games, SORT_DESC, $gameid);

$gameslength = count($games);

?>
<div class="container-lg">
	<div class="row my-4 p-0">
		<?php
		for($i = 0; $i < $gameslength; $i++)
		{
			?>
			<a class="item" href="game.php?game=<?php echo $games[$i]['gameid']; ?>" >
				<div class="card m-1" style="width: 14rem;">
					<img 
						src="<?php echo $games[$i]['logo']; ?>" 
						class="card-img-top" 
						alt="Game image"
					>
					<div class="card-body text-dark">
						<h5 class="card-title ">
							<?php echo $games[$i]['name']; ?>
						</h5>
						<p class="card-text">
							<?php echo $games[$i]['description']; ?>
						</p>
					</div>
					<div class="card-footer">
						<small class="text-muted">
							<?php echo $games[$i]['modcount']; ?>
							mods, 
							<?php echo $games[$i]['downloads']; ?>
							downloads
						</small>
					</div>
				</div>
			</a>
		<?php
		}
		?>
	</div>
</div>

<?php require 'bot.php' ?>
