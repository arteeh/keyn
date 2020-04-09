<?php require 'top.php' ?>

<?php

$gameid = $_GET["game"];

//get game data
$datadir = "db/games/$gameid/data";
$logodir = "db/games/$gameid/logo.webp";
$bannerdir = "db/games/$gameid/banner.webp";

$datafile = fopen($datadir, "r");

$name = fgets($datafile);
$name = trim($name,"name=");
$description = fgets($datafile);
$description = trim($description,"description=");
$modcount = fgets($datafile);
$modcount = trim($modcount,"modcount=");
$downloads = fgets($datafile);
$downloads = trim($downloads,"downloads=");

fclose($datafile);
?>

<div class="card bg-dark text-white my-4">
	<img class="card-img" src="<?php echo $bannerdir; ?>" alt="Card image">
	<div class="card-img-overlay text-shadow">
		<h2 class="card-title"><?php echo $name; ?></h2>
		<p class="card-text"><?php echo $description; ?></p>
		<p class="card-text">
			Mods: <?php echo $modcount; ?>
		</p>
		<p class="card-text">
			Total downloads: <?php echo $downloads; ?>
		</p>
	</div>
</div>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<div class="btn-group" role="group" aria-label="First group">
		<button type="button" class="btn btn-secondary">
			Previous
		</button>
		<button type="button" class="btn btn-secondary">
			Next
		</button>
	</div>
	<div class="input-group">
		<input type="text" class="form-control" placeholder="Search">
		<button type="button input-group-append" class="btn btn-secondary">
			Search
		</button>
	</div>
</div>

<?php require 'bot.php' ?>
