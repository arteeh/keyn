<?php
// Check if the game exists, otherwise error
$gameid = $_GET['game'];
$gamedir = "db/games/$gameid";
if(!is_dir($gamedir))
{
	header("Location: error.php");
	die();
}

require 'top.php';

//get data of this game and put it into variables
$gamedatadir = "$gamedir/data";
$gamelogodir = "$gamedir/logo.webp";
$gamebannerdir = "$gamedir/banner.webp";

$gamedatafile = fopen($gamedatadir, "r");
while(!feof($gamedatafile))
{
	$line = fgets($gamedatafile);
	if(strpos($line, 'name=') !== false)
		$gamename = trim($line,"name=");
	else if(strpos($line, 'description=') !== false)
		$gamedescription = trim($line,"description=");
	else if(strpos($line, 'modcount=') !== false)
		$gamemodcount = trim($line,"modcount=");
	else if(strpos($line, 'downloads=') !== false)
		$gamedownloads = trim($line,"downloads=");
}
fclose($gamedatafile);

$modopendir = opendir("db/games/$gameid/mods");
$mods = array();

$totaldownloads = 0;

while (($modid = readdir($modopendir)) !== false)
{
	if (!is_dir($modid))
	{
		$mod = array();
		
		$mod['modid'] = $modid;
		
		$modlogodir = "db/games/$gameid/mods/$modid/logo.webp";
		$mod['logo'] = $modlogodir;
		
		$moddatadir = "db/games/$gameid/mods/$modid/data";
		$moddatafile = fopen($moddatadir, "r");
		
		while(!feof($moddatafile))
		{
			$line = fgets($moddatafile);
			if(strpos($line, 'name=') !== false)
				$mod['name'] = trim($line,"name=");
			else if(strpos($line, 'description=') !== false)
				$mod['description'] = trim($line,"description=");
			else if(strpos($line, 'downloads=') !== false)
			{
				$dl = trim($line,"downloads=");
				$mod['downloads'] = $dl;
				$totaldownloads = $totaldownloads + intval($dl);
			}
			else if(strpos($line, 'seeders=') !== false)
				$mod['seeders'] = trim($line,"seeders=");
			
		}
		
		fclose($moddatafile);
		
		array_push($mods, $mod);
	}
}
closedir($modopendir);

$issearching = 0;
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

$sortby = "downloads";

if(isset($_GET['sortby']))
{
	if($_GET['sortby'] == "")		$sortby = "downloads";
	if($_GET['sortby'] == "downloads")	$sortby = "downloads";
	if($_GET['sortby'] == "new")		$sortby = "new";
	if($_GET['sortby'] == "seeders")		$sortby = "seeders";
	if($_GET['sortby'] == "updated")		$sortby = "updated";
	if($_GET['sortby'] == "released")	$sortby = "released";
}

//sort mods by downloads, descending
array_multisort(array_column($mods, $sortby), SORT_DESC, SORT_NUMERIC, $mods);


// PAGINATION

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
</div>

<div class="card bg-light text-white my-4">
	<img class="card-img" src="<?php echo $gamebannerdir; ?>" alt="Card image">
	<div class="card-img-overlay text-shadow">
		<h2 class="card-title"><?php echo $gamename; ?></h2>
		<p class="card-text"><?php echo $gamedescription; ?></p>
	</div>
</div>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<div class="mr-auto">
		<button type="button" class="text-dark btn btn-light" disabled>
			Mods: <?php echo $modslength; ?>
		</button>
		<button type="button" class="text-dark btn btn-light" disabled>
			Downloads: <?php echo $totaldownloads; ?>
		</button>
	</div>
	<div class="btn-group" role="group">
		<button
			id="btnGroupDrop1"
			type="button"
			class="btn btn-primary dropdown-toggle mr-1"
			data-toggle="dropdown"
		>
			Sort
		</button>
		<div class="dropdown-menu">
			<a class="dropdown-item" href="game.php?
				game=<?php echo $gameid; ?>&
				query=<?php echo $query; ?>&
				sortby=downloads">
				Downloads</a>
			<a class="dropdown-item" href="game.php?
				game=<?php echo $gameid; ?>&
				query=<?php echo $query; ?>&
				sortby=new">
				New</a>
			<a class="dropdown-item" href="game.php?
				game=<?php echo $gameid; ?>&
				query=<?php echo $query; ?>&
				sortby=seeders">
				Seeders</a>
			<a class="dropdown-item" href="game.php?
				game=<?php echo $gameid; ?>&
				query=<?php echo $query; ?>&
				sortby=updated">
				Updated</a>
			<a class="dropdown-item" href="game.php?
				game=<?php echo $gameid; ?>&
				query=<?php echo $query; ?>&
				sortby=released">
				Released</a>
			
		</div>
	</div>
	<form class="form-inline" action="game.php" method="get">
		<div class="input-group">
			<input type="text" name="query" class="form-control" placeholder="exact hits please <3">
			<input type="hidden" name="game" value="<?php echo $gameid; ?>"/>
			<input type="hidden" name="sortby" value="<?php echo $sortby; ?>"/>
			<div class="input-group-append">
				<button type="submit" class="input-group-text">
					Search
				</button>
			</div>
		</div>
	</form>
</div>

<?php require 'pagination.php' ?>

<div class="container my-4">
	<div class="row justify-content-center">
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
				href="mod.php?
				game=<?php echo $gameid; ?>&
				mod=<?php echo $mods[$i]['modid']; ?>"
			>
				<div class="card m-1" style="width: 13.375rem;">
					<img
						src="<?php echo $mods[$i]['logo']; ?>"
						class="card-img-top"
						alt="Mod image"
					>
					<div class="card-body text-dark">
						<h5 class="card-title ">
							<?php echo $mods[$i]['name']; ?>
						</h5>
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

<?php require 'pagination.php' ?>

<?php require 'bot.php' ?>
