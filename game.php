<?php require 'top.php' ?>

<?php
$gameid = $_GET["game"];

//get game data
$gamedir = "db/games/$gameid";
$gamedatadir = "$gamedir/data";
$gamelogodir = "$gamedir/logo.webp";
$gamebannerdir = "$gamedir/banner.webp";

$gamedatafile = fopen($gamedatadir, "r");

$gamename = fgets($gamedatafile);
$gamename = trim($gamename,"name=");
$gamedescription = fgets($gamedatafile);
$gamedescription = trim($gamedescription,"description=");
$gamemodcount = fgets($gamedatafile);
$gamemodcount = trim($gamemodcount,"modcount=");
$gamedownloads = fgets($gamedatafile);
$gamedownloads = trim($gamedownloads,"downloads=");

fclose($gamedatafile);
?>

<?php
$modopendir = opendir("db/games/$gameid/mods");
$mods = array();

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
		
		$modname = fgets($moddatafile);
		$modname = trim($modname,"name=");
		$mod['name'] = $modname;
		
		$moddescription = fgets($moddatafile);
		$moddescription = trim($moddescription,"description=");
		$mod['description'] = $moddescription;
		
		$moddownloads = fgets($moddatafile);
		$moddownloads = trim($moddownloads,"downloads=");
		$mod['downloads'] = $moddownloads;
		
		fclose($moddatafile);
		
		array_push($mods, $mod);
	}
}
closedir($modopendir);

//sort mods by downloads, descending
array_column($modid, 'downloads');
array_multisort($mods, SORT_DESC, $modid);

$modslength = count($mods);
?>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<a href="index.php" type="button" class="btn btn-primary">
		Back home
	</a>
</div>

<div class="card bg-dark text-white my-4 bg-dark">
	<img class="card-img" src="<?php echo $gamebannerdir; ?>" alt="Card image">
	<div class="card-img-overlay text-shadow">
		<h2 class="card-title"><?php echo $gamename; ?></h2>
		<p class="card-text"><?php echo $gamedescription; ?></p>
	</div>
</div>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<div class="btn-group" role="group" aria-label="First group">
		<button type="button" class="btn btn-primary">
			Previous
		</button>
		<button type="button" class="btn btn-primary" disabled>
			Mods: <?php echo $gamemodcount; ?>
		</button>
		<button type="button" class="btn btn-primary" disabled>
			Downloads: <?php echo $gamedownloads; ?>
		</button>
		<button type="button" class="btn btn-primary">
			Next
		</button>
	</div>
	<div class="input-group">
		<input type="text" class="form-control" placeholder="Search">
		<button type="button input-group-append" class="btn btn-primary">
			Search
		</button>
	</div>
</div>

<div class="container-lg">
	<div class="row my-4 p-0">
		<?php
		for($i = 0; $i < $modslength; $i++)
		{
			?>
			<a
				class="item" 
				href="mod.php?
				game=<?php echo $gameid; ?>&
				mod=<?php echo $mods[$i]['modid']; ?>"
			>
				<div class="card m-1" style="width: 14rem;">
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
