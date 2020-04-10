<?php require 'top.php' ?>

<?php
$gameid = $_GET["game"];
$modid = $_GET["mod"];

//get game data
$gamedir = "db/games/$gameid";
$gamedatadir = "$gamedir/data";

$gamedatafile = fopen($gamedatadir, "r");
$gamename = fgets($gamedatafile);
$gamename = trim($gamename,"name=");
fclose($gamedatafile);

//get mod data
$moddir = "db/games/$gameid/mods/$modid";
$moddatadir = "$moddir/data";
$modlogodir = "$moddir/logo.webp";
$modbannerdir = "$moddir/banner.webp";

$moddatafile = fopen($moddatadir, "r");
$modname = fgets($moddatafile);
$modname = trim($modname,"name=");
$moddescription = fgets($moddatafile);
$moddescription = trim($moddescription,"description=");
$moddownloads = fgets($moddatafile);
$moddownloads = trim($moddownloads,"downloads=");
$modseeders = fgets($moddatafile);
$modseeders = trim($modseeders,"seeders=");
$modleechers = fgets($moddatafile);
$modleechers = trim($modleechers,"leechers=");
fclose($moddatafile);
?>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<a href="game.php?game=<?php echo $gameid; ?>" type="button" class="btn btn-primary">
		Back to <?php echo $gamename; ?>
	</a>
</div>

<div class="card bg-dark text-white my-4 bg-dark">
	<img class="card-img" src="<?php echo $modbannerdir; ?>" alt="Card image">
	<div class="card-img-overlay text-shadow">
		<h2 class="card-title"><?php echo $modname; ?></h2>
	</div>
</div>

<div class="card my-4">
	<div class="card-header">
		<ul class="nav nav-tabs card-header-tabs">
			<li class="nav-item">
				<a	class="nav-link  
					<?php
					if ($_GET[page] == "description" 
						|| $_GET[page] == "")
					{
						echo "active";
					}
					?>"
					href="mod.php?game=<?php echo $gameid; ?>
					&mod=<?php echo $modid; ?>
					&page=description">
					Description
				</a>
			</li>
			<li class="nav-item">
				<a	class="nav-link  
					<?php
					if ($_GET[page] == "downloads")
					{
						echo "active";
					}
					?>"
					href="mod.php?game=<?php echo $gameid; ?>
					&mod=<?php echo $modid; ?>
					&page=downloads">
					Downloads
				</a>
			</li>
			<li class="nav-item">
				<a	class="nav-link 
					<?php
					if ($_GET[page] == "comments")
					{
						echo "active";
					}
					?>"
					href="mod.php?game=<?php echo $gameid; ?>
					&mod=<?php echo $modid; ?>
					&page=comments">
					Comments
				</a>
			</li>
			<li class="nav-item text-right ml-auto">
				<a class="nav-link">
					Downloads: <?php echo $moddownloads; ?>
					&nbsp
					Seeders: <?php echo $modseeders; ?>
					&nbsp
					Leechers: <?php echo $modleechers; ?>
				</a>
			</li>
		</ul>
	</div>
	
	<?php
	if ($_GET[page] == "description" || $_GET[page] == "")
	{
	?>
	<div class="card-body">
		<h5 class="card-title">
			<?php
				echo $moddescription;
			?>
		</h5>
		<p class="card-text">
			<?php
			$moddescriptionfile = fopen("$moddir/bigdescription", "r");
			
			while(!feof($moddescriptionfile))
			{
				$line = fgets($moddescriptionfile);
				echo "<p>";
				echo $line;
				echo "</p>";
			}
			
			fclose($moddescriptionfile);
			?>
		</p>
	</div>
	<?php
	}
	else if ($_GET[page] == "downloads")
	{
	?>
	<div class="card-body">
		<h5 class="card-title">
			Downloads coming soon!
		</h5>
	</div>
	<?php
	}
	else if ($_GET[page] == "comments")
	{
	?>
	<div class="card-body">
		<h5 class="card-title">
			Comments coming soon!
		</h5>
	</div>
	<?php
	}
	?>
</div>

<?php require 'bot.php' ?>
