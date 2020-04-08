<!doctype html>
<html lang="en">

<head>
<!-- Other -->
<meta charset="utf-8">
<title>Keyndb</title>
<meta name="description" content="Keyn mod hosting site!">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" type="text/css" href="style.css">

<!-- Bootstrap CSS -->
<link
	rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
	integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
	crossorigin="anonymous"
>

<!-- Favicon stuff -->
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#b91d47">
<meta name="theme-color" content="#cefcab">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="#">
		<img src="assets/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
		Keyndb
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="#">Games</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Mods</a>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="#">Log in</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Register</a>
			</li>
		</ul>
	</div>
</nav>

<div class="jumbotron  m-4">
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
		
		$datadir = "db/games/" . $item . "/data";
		$datafile = fopen($datadir, "r");
		$game['gameid'] = $item;
		
		$logo = "db/games/" . $item . "/logo.webp";
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
<div class="row m-4">
<?php

for($i = 0; $i < $gameslength; $i++)
{
	?>
	<a class="game" href="game.php?game=<?php echo $games[$i]['gameid']; ?>" >
	<div class="card m-1" style="width: 18rem;">
		<img src="<?php echo $games[$i]['logo']; ?>" class="card-img-top" alt="Game image">
		<div class="card-body text-dark">
			<h5 class="card-title">
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

<footer class="card">
	<div class="card-body">
		<p class="card-text">This website is created and owned by arteeh. <a href="https://www.arteeh.com">Find me here.</a></p>
	</div>
</footer>

<!-- Bootstrap Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
	src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
	integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
	crossorigin="anonymous"
></script>
<script
	src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
	crossorigin="anonymous"
></script>
<script
	src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
	integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
	crossorigin="anonymous"
></script>

</body>
</html>
