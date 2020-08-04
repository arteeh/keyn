<?php

$gameid = $_GET['game'];
$gamedir = "db/games/$gameid";

// Check if the game exists, otherwise error
if(!is_dir($gamedir))
{
	header("Location: error");
	die();
}

require_once 'top.php';
require_once 'libgame.php';
require_once 'libmod.php';

// Get data from db
$game = getGame($gameid);
$mods = getMods($game['id']);

// Count the total amount of downloads for this game
$totaldownloads = 0;
foreach($mods as $mod)
{
	$totaldownloads = $totaldownloads + intval($mod['downloads']);
}

// Check if the user is searching
$issearching = 0;
$query = "";
if(isset($_GET['query']))
{
	if($_GET['query'] != "")
	{
		$issearching = 1;
	}
}

if($issearching)
{
	$hits = array();
	$query = $_GET['query'];
	
	$modsinarray = count($mods);
	
	foreach ($mods as $mod)
	{
		if(strpos($mod['name'], $query) !== false)
			array_push($hits, $mod);
	}
	$modslength = count($hits);
}
else $modslength = count($mods);

// Sort mods
$sortby = "downloads";
if(isset($_GET['sortby']))
{
	if($_GET['sortby'] == "")				$sortby = "downloads";
	else if($_GET['sortby'] == "downloads")	$sortby = "downloads";
	else if($_GET['sortby'] == "seeders")	$sortby = "seeders";
	else if($_GET['sortby'] == "updated")	$sortby = "updated";
	else if($_GET['sortby'] == "released")	$sortby = "released";
}
array_multisort(array_column($mods, $sortby), SORT_DESC, SORT_NUMERIC, $mods);

// Pagination
$limit = 20;
// How may adjacent page links should be shown on each side of the current page link.
$adjacents = 1;
$total_pages = ceil($modslength / $limit);

if(isset($_GET['page']) && $_GET['page'] != "")
{
	$page = $_GET['page'];
	$offset = $limit * ($page-1);
}
else
{
	$page = 1;
	$offset = 0;
}
// Here we generate the range of the page numbers which will display.
if($total_pages <= (1+($adjacents * 2)))
{
	$start = 1;
	$end   = $total_pages;
}
else
{
	if(($page - $adjacents) > 1)
	{
		if(($page + $adjacents) < $total_pages)
		{ 
			$start = ($page - $adjacents);
			$end   = ($page + $adjacents);
		}
		else
		{
			$start = ($total_pages - (1+($adjacents*2)));
			$end   = $total_pages;
		}
	}
	else
	{   
		$start = 1;
		$end   = (1+($adjacents * 2));
	}
}
?>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<a href="index.php" type="button" class="btn btn-primary">
		Back home
	</a>
	<span class="my-auto">
		Mods: <?php echo $modslength; ?>
		&nbsp
		Downloads: <?php echo $totaldownloads; ?>
	</span>
</div>

<div class="card text-white my-4">
	<object	class="card-img"
			data="<?php echo $game['bannerdir']; ?>"
			type="image/webp"
	>
		<img class="card-img" src="<?php echo "db/placeholdergame/banner.webp"; ?>" alt="Game banner image">
	</object>
	<div class="card-img-overlay text-shadow">
		<h2 class="card-title"><?php echo $game['name']; ?></h2>
		<p class="card-text"><?php echo $game['description']; ?></p>
	</div>
</div>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<div class="btn-group" role="group">
		<button
			type="button"
			class="btn btn-primary dropdown-toggle mr-1"
			data-toggle="dropdown">
			Sort
		</button>
		<div class="dropdown-menu">
			<a	class="dropdown-item
				<?php if($sortby == "downloads") echo "active" ?>"
				href="game?
				game=<?php echo $game['id']; ?>&
				query=<?php echo $query; ?>&
				sortby=downloads">
				Downloads
			</a>
			<a	class="dropdown-item
				<?php if($sortby == "seeders") echo "active" ?>"
				href="game?
				game=<?php echo $game['id']; ?>&
				query=<?php echo $query; ?>&
				sortby=seeders">
				Seeders
			</a>
			<a	class="dropdown-item
				<?php if($sortby == "updated") echo "active" ?>"
				href="game?
				game=<?php echo $game['id']; ?>&
				query=<?php echo $query; ?>&
				sortby=updated">
				Updated
			</a>
			<a	class="dropdown-item
				<?php if($sortby == "released") echo "active" ?>"
				href="game?
				game=<?php echo $game['id']; ?>&
				query=<?php echo $query; ?>&
				sortby=released">
				Released
			</a>
		</div>
	</div>
	<form class="form-inline" action="game.php" method="get">
		<div class="input-group">
			<input	type="text"
					name="query"
					class="form-control"
					size="14"
					value="<?php if(($query !== "")) echo $query; ?>"
					placeholder="exact hits please <3">
			<input type="hidden" name="game" value="<?php echo $game['id']; ?>"/>
			<input type="hidden" name="sortby" value="<?php echo $sortby; ?>"/>
			<div class="input-group-append">
				<button	type="submit"
					class="btn btn-primary input-group-text">
					Search
				</button>
			</div>
		</div>
	</form>
</div>

<?php if($modslength > $limit) require 'pagination.php'; ?>

<div class="my-4 p-0">
	<div class="row justify-content-center p-0">
		<?php
		$firsttoshow = ($page - 1) * $limit;
		if(($firsttoshow+$limit) >= ($modslength-($firsttoshow)))
			$lasttoshow = $modslength;
		else
			$lasttoshow = $firsttoshow + $limit;
		for($i = $firsttoshow; $i < $lasttoshow; $i++)
		{
		?>
			<a
				class="item" 
				href="mod?
				game=<?php echo $game['id']; ?>&
				mod=<?php echo $mods[$i]['id']; ?>"
			>
				<div class="card m-1" style="width: 11.5rem;">
					<object	class="card-img"
							data="<?php echo $mods[$i]['logodir']; ?>"
							type="image/webp"
					>
						<img	src="<?php echo "db/placeholdermod/logo.webp"; ?>"
								class="card-img-top"
								alt="Mod logo"
						>
					</object>
					<div class="card-body text-dark">
						<h6 class="card-title ">
							<?php echo $mods[$i]['name']; ?>
						</h6>
					</div>
					<div class="card-footer">
						<small class="text-muted">
							<?php echo $mods[$i]['downloads']; ?>
							downloads, 
							<?php echo $mods[$i]['seeders']; ?>
							seeders
						</small>
					</div>
				</div>
			</a>
		<?php
		}
		?>
	</div>
</div>

<?php if($modslength > $limit) require 'pagination.php'; ?>

<?php require_once 'bot.php'; ?>
