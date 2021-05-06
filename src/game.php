<?php

include_once "common/database.php";

//checkIfExists("games",$_GET['game']);

include_once "common/top.php";

$game = new Game();
$game->load($_GET['game']);
$game->loadModArray();

$filteredModArray = array();
$filteredModCount = 404;

// Check if the user is searching
$isSearching = 0;
$query = "";
if(isset($_GET['query']) && $_GET['query'] != "")
{
	$isSearching = 1;
	$query = $_GET['query'];
	foreach ($game->getModArray() as $mod)
	{
		if(strpos($mod->getName(), $query) !== false)
		{
			array_push($filteredModArray, $mod);
		}
	}
	$filteredModCount = count($filteredModArray);
}
else
{
	$filteredModArray = $game->getModArray();
	$filteredModCount = $game->GetModCount();
}

// Sort mods
$sortBy = "downloadCount";
if(isset($_GET['sortBy'])) $sortBy = $_GET['sortBy'];
$filteredModArray = sortObjectArray($filteredModArray,$sortBy,true);

// Pagination

$limit = 20;
// How may adjacent page links should be shown on each side of the current page link.
$adjacents = 1;
$totalPages = ceil($filteredModCount / $limit);

if(isset($_GET['page']) && $_GET['page'] != "")
{
	$page = $_GET['page'];
	$offset = $limit * ($page - 1);
}
else
{
	$page = 1;
	$offset = 0;
}

// Here we generate the range of the page numbers which will display.
if($totalPages <= (1 + ($adjacents * 2)))
{
	$start = 1;
	$end   = $totalPages;
}
else
{
	if(($page - $adjacents) > 1)
	{
		if(($page + $adjacents) < $totalPages)
		{ 
			$start = ($page - $adjacents);
			$end   = ($page + $adjacents);
		}
		else
		{
			$start = ($totalPages - (1+($adjacents*2)));
			$end   = $totalPages;
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
		Mods: <?=$game->getModCount()?>
		&nbsp
		Downloads: <?=$game->getDownloadCount()?>
	</span>
</div>

<div class="card text-white my-4">
	<img class="card-img" src="<?=$game->getBanner()?>"></img>
	<div class="card-img-overlay text-shadow">
		<h2 class="card-title"><?=$game->getName()?></h2>
		<p class="card-text"><?=$game->getDescription()?></p>
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
				<?php if($sortBy == "downloadCount") echo "active" ?>"
				href="game?
				game=<?=$game->getId()?>&
				<?php if($query != "") echo "query=",$query,"&"; ?>
				sortBy=downloadCount">
				Downloads
			</a>
			<a	class="dropdown-item
				<?php if($sortBy == "seederCount") echo "active" ?>"
				href="game?
				game=<?=$game->getId()?>&
				<?php if($query != "") echo "query=",$query,"&"; ?>
				sortBy=seederCount">
				Seeders
			</a>
			<a	class="dropdown-item
				<?php if($sortBy == "updateDate") echo "active" ?>"
				href="game?
				game=<?=$game->getId()?>&
				<?php if($query != "") echo "query=",$query,"&"; ?>
				sortBy=updateDate">
				Updated
			</a>
			<a	class="dropdown-item
				<?php if($sortBy == "releaseDate") echo "active" ?>"
				href="game?
				game=<?=$game->getId()?>&
				<?php if($query != "") echo "query=",$query,"&"; ?>
				sortBy=releaseDate">
				Released
			</a>
		</div>
	</div>
	<form class="form-inline" action="game" method="get">
		<div class="input-group">
			<input type="hidden" name="game" value="<?=$game->getId()?>"/>
			<input	type="text"
					name="query"
					class="form-control"
					size="16"
					value="<?php if(($query !== "")) echo $query; ?>"
					placeholder="exact hits please <3">
			<input type="hidden" name="sortBy" value="<?=$sortBy?>"/>
			<div class="input-group-append">
				<button	type="submit"
					class="btn btn-primary input-group-text">
					Search
				</button>
			</div>
		</div>
	</form>
</div>

<?php if($filteredModCount > $limit) require "common/pagination.php"; ?>

<div class="my-4 p-0">
	<div class="row justify-content-center p-0">
		<?php
		
		$firstToShow = ($page - 1) * $limit;
		if(($firstToShow + $limit) >= ($filteredModCount - ($firstToShow)))
		{
			$lastToShow = $filteredModCount;
		}
		else $lastToShow = $firstToShow + $limit;
		
		for($i = $firstToShow; $i < $lastToShow; $i++)
		{
			?>
			<a class="item" href="mod?mod=<?=$i?>">
				<div class="card text-dark m-1" style="width: 11.5rem;">
					<img class="card-img" src="<?=$filteredModArray[$i]->getLogo()?>"></img>
					<div class="card-body">
						<h6 class="card-title">
							<?=$filteredModArray[$i]->getName()?>
						</h6>
					</div>
					<div class="card-footer">
						<small class="text-muted">
							<?=$filteredModArray[$i]->getDownloadCount()?>
							downloads, 
							<?=$filteredModArray[$i]->getSeederCount()?>
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

<?php if($filteredModCount > $limit) require "common/pagination.php"; ?>

<?php require_once "common/bot.php"; ?>
