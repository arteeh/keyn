<?php
// Check if game and mod in GET exist to prevent issues
$gameid = $_GET['game'];
$gamedir = "db/games/$gameid";
if(!is_dir($gamedir))
{
	header("Location: error.php");
	die();
}

$modid = $_GET['mod'];
$moddir = "db/games/$gameid/mods/$modid";
if(!is_dir($moddir))
{
	header("Location: error.php");
	die();
}

require 'top.php';

//get game data
$gamedatadir = "$gamedir/data";
$gamedatafile = fopen($gamedatadir, "r");
$gamename = fgets($gamedatafile);
$gamename = trim(str_replace("name=","",$gamename));
fclose($gamedatafile);

//get mod data
$moddatadir = "$moddir/data";
$modlogodir = "$moddir/logo.webp";
$modbannerdir = "$moddir/banner.webp";

$moddatafile = fopen($moddatadir, "r");
while(!feof($moddatafile))
{
	$line = fgets($moddatafile);
	if(strpos($line, 'name=') !== false)
		$modname = trim(str_replace("name=","",$line));
	else if(strpos($line, 'description=') !== false)
		$moddescription = trim(str_replace("description=","",$line));
	else if(strpos($line, 'downloads=') !== false)
		$moddownloads = trim(str_replace("downloads=","",$line));
	else if(strpos($line, 'seeders=') !== false)
		$modseeders = trim(str_replace("seeders=","",$line));
	else if(strpos($line, 'leechers=') !== false)
		$modleechers = trim(str_replace("leechers=","",$line));
}
fclose($moddatafile);
?>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<a href="game.php?game=<?php echo $gameid; ?>" type="button" class="btn btn-primary">
		Back to <?php echo $gamename; ?>
	</a>
	<span class="my-auto">
		Downloads: <?php echo $moddownloads; ?>
		&nbsp
		Seeders: <?php echo $modseeders; ?>
		&nbsp
		Leechers: <?php echo $modleechers; ?>
	</span>
</div>

<div class="card bg-light text-white my-4">
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
					if ($_GET['page'] == "description" 
						|| $_GET['page'] == "")
					{
						echo "active";
					}
					?>"
					href="mod?game=<?php echo $gameid; ?>
					&mod=<?php echo $modid; ?>
					&page=description">
					Description
				</a>
			</li>
			<li class="nav-item">
				<a	class="nav-link  
					<?php
					if ($_GET['page'] == "downloads")
					{
						echo "active";
					}
					?>"
					href="mod?game=<?php echo $gameid; ?>
					&mod=<?php echo $modid; ?>
					&page=downloads">
					Downloads
				</a>
			</li>
			<li class="nav-item">
				<a	class="nav-link 
					<?php
					if ($_GET['page'] == "comments")
					{
						echo "active";
					}
					?>"
					href="mod?game=<?php echo $gameid; ?>
					&mod=<?php echo $modid; ?>
					&page=comments">
					Comments
				</a>
			</li>
		</ul>
	</div>
	
	<?php
	// Set description as default page to open
	if(!isset($_GET['page'])) $_GET['page'] = 'description';
	
	if ($_GET['page'] == 'description')
	{
	?>
	<div class="card-body">
		<div class="card-text">
			<?php
			$moddescriptionfile = fopen("$moddir/bigdescription", "r");
			
			while(!feof($moddescriptionfile))
			{
				echo fgets($moddescriptionfile);
			}
			
			fclose($moddescriptionfile);
			?>
		</div>
	</div>
	<?php
	}
	else if ($_GET['page'] == "downloads")
	{
	?>
	<div class="card-body">
		<h5 class="card-title">
			Downloads coming soon!
		</h5>
	</div>
	<?php
	}
	else if ($_GET['page'] == "comments")
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
