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
$dh = opendir("db/games");
$games = array();

while (($item = readdir($dh)) !== false)
{
	if (!is_dir($item))
	{
		$game = array();
		
		$datadir = "db/games/$item/data";
		$datafile = fopen($datadir, "r");
		$game['gameid'] = $item;
		
		$logo = "db/games/$item/logo.webp";
		$game['logo'] = $logo;
		
		$name = fgets($datafile);
		$name = trim($name,"name=");
		$game['name'] = $name;
		
		$description = fgets($datafile);
		$description = trim($description,"description=");
		$game['description'] = $description;
		
		$modcount = fgets($datafile);
		$modcount = trim($modcount,"modcount=");
		$game['modcount'] = $modcount;
		
		$downloads = fgets($datafile);
		$downloads = trim($downloads,"downloads=");
		$game['downloads'] = $downloads;
		
		array_push($games, $game);
		
		fclose($datafile);
	}
}
closedir($dh);

//sort by downloads, descending
array_column($item, 'downloads');
array_multisort($games, SORT_DESC, $item);

$gameslength = count($games);

?>
<div class="container-lg">
<div class="row my-4 p-0">
<?php
for($i = 0; $i < $gameslength; $i++)
{
?>
	<a class="game" href="game.php?game=<?php echo $games[$i]['gameid']; ?>" >
	<div class="card m-1" style="width: 14rem;">
		<img src="<?php echo $games[$i]['logo']; ?>" class="card-img-top" alt="Game image">
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
				<?php echo $games[$i]['modcount']; ?> mods, 
				<?php echo $games[$i]['downloads']; ?> downloads
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
